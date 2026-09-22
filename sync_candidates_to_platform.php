<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

echo "======================================================\n";
echo "   WORLDSKILLS ALGERIA - SYNC & INTEGRATION ENGINE    \n";
echo "======================================================\n\n";

$startTime = microtime(true);

// 1. SYNC ORGANIZATIONS (ETABLISSEMENT -> ORGANIZATIONS)
echo "[1/4] Syncing Organizations from etablissement...\n";
$existingOrgs = DB::table('organizations')->get(['id', 'name_ar', 'code'])->keyBy('name_ar');
$etabs = DB::table('etablissement')->get();

$newOrgsCount = 0;
$orgMap = []; // IDetablissement -> organization_id

foreach ($etabs as $etab) {
    $name = trim($etab->Nom);
    if (isset($existingOrgs[$name])) {
        $orgMap[$etab->IDetablissement] = $existingOrgs[$name]->id;
    } else {
        // Insert missing organization
        $newId = DB::table('organizations')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'code' => ($etab->CodeEtsMihnati ? $etab->CodeEtsMihnati . '_' . $etab->IDetablissement : ('ORG-' . $etab->IDetablissement)),
            'name_ar' => $name ?: ($etab->NomFr ?: 'مؤسسة تكوينية ' . $etab->IDetablissement),
            'name_fr' => $etab->NomFr ?: '',
            'name_en' => '',
            'type' => 'cfpa',
            'country_id' => 1,
            'wilaya_id' => ($etab->IDDFEP >= 1 && $etab->IDDFEP <= 58) ? $etab->IDDFEP : null,
            'email' => $etab->Email ?: '',
            'phone' => $etab->Tel ?: '',
            'address' => $etab->Adres ?: '',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $orgMap[$etab->IDetablissement] = $newId;
        $newOrgsCount++;
    }
}
echo "  -> Total organizations mapped: " . count($orgMap) . " (New added: {$newOrgsCount})\n";
echo "  -> Current organizations in platform: " . DB::table('organizations')->count() . "\n\n";

// 2. BUILD SKILL MAP
echo "[2/4] Building Skill Code Map...\n";
$skills = DB::table('skills')->get();
$skillMap = [];
foreach ($skills as $s) {
    $num = preg_replace('/[^0-9]/', '', $s->code);
    if ($num !== '') {
        $skillMap[$num] = $s->id;
        $skillMap[(int)$num] = $s->id;
        $skillMap[sprintf('%02d', (int)$num)] = $s->id;
    }
    $skillMap[strtolower(trim($s->code))] = $s->id;
}
echo "  -> Skills registered in platform: " . count($skills) . "\n\n";

// 3. PROCESS CANDIDATES
echo "[3/4] Processing 8,902 Candidates & Classifying Qualification Status...\n";

$candidates = DB::table('candidates')->orderBy('id')->get();
$total = $candidates->count();

$counts = [
    'QUALIFIED_NATIONAL' => 0,
    'QUALIFIED_REGIONAL' => 0,
    'APPROVED'           => 0,
    'REJECTED'           => 0,
    'PENDING'            => 0,
];

// Clean existing test registrations/participants to avoid duplicate key conflicts if re-running
echo "  -> Preparing clean sync of participants and registrations...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0');
DB::table('registrations')->truncate();
DB::table('participant_profiles')->truncate();
// Remove previously imported participant users
DB::table('users')->where('id', '>', 1000)->delete();
DB::table('model_has_roles')->where('role_id', 13)->delete();
DB::statement('SET FOREIGN_KEY_CHECKS=1');

$existingUsers = DB::table('users')->pluck('id', 'email')->toArray();

$userBatch = [];
$profileBatch = [];
$regBatch = [];
$roleBatch = [];

$batchSize = 500;
$processed = 0;

foreach ($candidates as $c) {
    // Determine Qualification Status strictly according to tournament hierarchy:
    // 1. National: Passed regional championships (accepted_regional = 1 or promoted_at set)
    // 2. Regional: Champion of Wilaya (Rank #1 in Wilaya with accepted_wilaya = 1)
    // 3. Approved: Accepted in Wilaya competition
    // 4. Rejected: Rejected in registration
    // 5. Pending: Still pending verification
    
    $isNational = ($c->accepted_regional == 1) || (!empty($c->promoted_at) && $c->promoted_at !== '0000-00-00 00:00:00');
    $isRegional = ($c->rank_wilaya == 1 && $c->accepted_wilaya == 1 && !$isNational);
    
    if ($isNational) {
        $status = 'QUALIFIED_NATIONAL';
    } elseif ($isRegional) {
        $status = 'QUALIFIED_REGIONAL';
    } elseif ($c->status === 'approved' || $c->accepted_wilaya == 1) {
        $status = 'APPROVED';
    } elseif ($c->status === 'rejected') {
        $status = 'REJECTED';
    } else {
        $status = 'PENDING';
    }
    
    $counts[$status]++;
    
    // Resolve Skill ID
    $cleanSkill = trim($c->skill_code, " \t\n\r\0\x0B'\"");
    $numSkill = preg_replace('/[^0-9]/', '', $cleanSkill);
    $skillId = $skillMap[$cleanSkill] ?? ($skillMap[(int)$numSkill] ?? 1);
    
    // Resolve Organization ID
    $orgId = $orgMap[$c->idetablissement] ?? null;
    
    // Resolve Wilaya ID
    $wilayaId = ($c->iddfep >= 1 && $c->iddfep <= 58) ? $c->iddfep : null;
    
    // Resolve Email to avoid collision
    $email = trim(strtolower($c->email));
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = 'candidate_' . $c->id . '@worldskills.dz';
    }
    if (isset($existingUsers[$email])) {
        $email = 'cand_' . $c->id . '_' . $email;
    }
    $existingUsers[$email] = true;
    
    $userId = 1000 + $c->id; // deterministic user ID
    $profileId = $c->id;      // deterministic profile ID
    
    $fullName = trim(($c->prenom_ar ?: $c->prenom_fr) . ' ' . ($c->nom_ar ?: $c->nom_fr));
    
    $userBatch[] = [
        'id' => $userId,
        'uuid' => (string) Str::uuid(),
        'name' => $fullName ?: ('مترشح ' . $c->id),
        'email' => $email,
        'password' => $c->password ?: bcrypt('WorldSkills2026!'),
        'country_id' => 1,
        'locale' => 'ar',
        'wilaya_id' => $wilayaId,
        'organization_id' => $orgId,
        'is_active' => ($c->status === 'rejected') ? 0 : 1,
        'created_at' => $c->created_at ?: now(),
        'updated_at' => $c->updated_at ?: now(),
    ];
    
    $profileBatch[] = [
        'id' => $profileId,
        'uuid' => (string) Str::uuid(),
        'user_id' => $userId,
        'first_name_ar' => $c->prenom_ar ?: '',
        'last_name_ar' => $c->nom_ar ?: '',
        'first_name_fr' => $c->prenom_fr ?: '',
        'last_name_fr' => $c->nom_fr ?: '',
        'first_name_en' => '',
        'last_name_en' => '',
        'gender' => 'male',
        'date_of_birth' => $c->date_naissance ?: '2004-01-01',
        'phone' => $c->telephone ?: '',
        'email' => $email,
        'address' => $c->lieu_naissance ?: '',
        'national_id' => $c->nin ?: '',
        'wilaya_id' => $wilayaId,
        'organization_id' => $orgId,
        'created_at' => $c->created_at ?: now(),
        'updated_at' => $c->updated_at ?: now(),
    ];
    
    $regBatch[] = [
        'id' => $c->id,
        'uuid' => (string) Str::uuid(),
        'registration_number' => 'WSAP-2026-DZ-' . str_pad($c->id, 6, '0', STR_PAD_LEFT),
        'verification_token' => Str::random(40),
        'edition_id' => 1,
        'participant_id' => $profileId,
        'country_id' => 1,
        'skill_id' => $skillId,
        'status' => $status,
        'suit_size' => in_array($c->clothing_size, ['XS','S','M','L','XL','2XL','3XL','4XL']) ? $c->clothing_size : null,
        'shoe_size' => $c->shoe_size ?: null,
        'height_cm' => $c->height_cm ?: null,
        'submitted_at' => $c->created_at ?: now(),
        'reviewed_at' => $c->updated_at ?: now(),
        'created_at' => $c->created_at ?: now(),
        'updated_at' => $c->updated_at ?: now(),
    ];
    
    $roleBatch[] = [
        'role_id' => 13, // PARTICIPANT
        'model_type' => 'App\\Models\\User',
        'model_id' => $userId,
    ];
    
    $processed++;
    
    if (count($userBatch) >= $batchSize) {
        DB::table('users')->insert($userBatch);
        DB::table('participant_profiles')->insert($profileBatch);
        DB::table('registrations')->insert($regBatch);
        DB::table('model_has_roles')->insert($roleBatch);
        
        $userBatch = [];
        $profileBatch = [];
        $regBatch = [];
        $roleBatch = [];
        echo "  -> Processed {$processed} / {$total} candidates...\n";
    }
}

// Insert remainder
if (!empty($userBatch)) {
    DB::table('users')->insert($userBatch);
    DB::table('participant_profiles')->insert($profileBatch);
    DB::table('registrations')->insert($regBatch);
    DB::table('model_has_roles')->insert($roleBatch);
    echo "  -> Processed {$processed} / {$total} candidates.\n";
}

$elapsed = round(microtime(true) - $startTime, 2);

echo "\n[4/4] Sync Completed in {$elapsed} seconds!\n";
echo "======================================================\n";
echo "           FINAL MIGRATION & AUDIT SUMMARY            \n";
echo "======================================================\n";
echo sprintf("  Total Users in Platform      : %d\n", DB::table('users')->count());
echo sprintf("  Total Participant Profiles   : %d\n", DB::table('participant_profiles')->count());
echo sprintf("  Total Registrations          : %d\n", DB::table('registrations')->count());
echo sprintf("  Total Organizations          : %d\n", DB::table('organizations')->count());
echo "------------------------------------------------------\n";
echo "  TOURNAMENT QUALIFICATION BREAKDOWN:\n";
echo sprintf("  [1] QUALIFIED_NATIONAL (النهائيات الوطنية) : %d\n", $counts['QUALIFIED_NATIONAL']);
echo sprintf("  [2] QUALIFIED_REGIONAL (البطولة الجهوية)   : %d (أوائل الولايات)\n", $counts['QUALIFIED_REGIONAL']);
echo sprintf("  [3] APPROVED           (مقبول ولائياً)    : %d\n", $counts['APPROVED']);
echo sprintf("  [4] REJECTED           (مرفوض)             : %d\n", $counts['REJECTED']);
echo sprintf("  [5] PENDING            (قيد المعالجة)      : %d\n", $counts['PENDING']);
echo "======================================================\n";

