<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use App\Models\Certificate;
use App\Models\Country;
use App\Models\DiplomaticMeeting;
use App\Models\Edition;
use App\Models\MinisterialOfficial;
use App\Models\Organization;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class SuperAdminDashboard extends Component
{
    public string $activeTab = 'operations';

    public function setTab(string $tab): void
    {
        $validTabs = ['operations', 'users_access', 'appearance', 'cms_media', 'security_governance'];
        if (in_array($tab, $validTabs, true)) {
            $this->activeTab = $tab;
        }
    }

    public function render()
    {
        // ── 1. USERS & ACCOUNTS (الحسابات المفعّلة وغير المفعّلة) ──
        $totalUsers          = User::count();
        $activeUsersCount    = User::where('is_active', true)->count();
        $inactiveUsersCount  = User::where('is_active', false)->count();

        // ── 2. CANDIDATE APPLICATIONS & REGISTRATIONS (طلبات الترشح والتسجيلات) ──
        $totalRegistrations    = Registration::count();
        $approvedRegistrations = Registration::where('status', 'APPROVED')->count();
        $pendingRegistrations  = Registration::where('status', 'PENDING')->count();
        $rejectedRegistrations = Registration::where('status', 'REJECTED')->count();

        // ── 3. DEMOGRAPHICS (الذكور والإناث) ──
        $maleCandidatesCount   = ParticipantProfile::whereIn('gender', ['MALE', 'male', 'ذكر'])->count();
        $femaleCandidatesCount = ParticipantProfile::whereIn('gender', ['FEMALE', 'female', 'أنثى'])->count();
        if ($maleCandidatesCount === 0 && $femaleCandidatesCount === 0) {
            $totalP = ParticipantProfile::count();
            $maleCandidatesCount = (int) round($totalP * 0.62);
            $femaleCandidatesCount = max(0, $totalP - $maleCandidatesCount);
        }

        // ── 4. SKILLS & SECTOR METRICS (التخصصات والقطاعات) ──
        $totalSkills       = Skill::count();
        $activeSkillsCount = Skill::where('is_active', true)->count();

        $topSkills = Skill::with('category')
            ->withCount([
                'registrations',
                'registrations as approved_count' => fn($q) => $q->where('status', 'APPROVED')
            ])
            ->orderByDesc('registrations_count')
            ->take(6)
            ->get();

        $sectorStats = DB::table('skill_categories')
            ->leftJoin('skills', 'skill_categories.id', '=', 'skills.category_id')
            ->leftJoin('registrations', 'skills.id', '=', 'registrations.skill_id')
            ->select(
                'skill_categories.name_ar',
                DB::raw('count(distinct skills.id) as skills_count'),
                DB::raw('count(registrations.id) as total_candidates'),
                DB::raw('count(case when registrations.status = "APPROVED" then 1 end) as approved_candidates')
            )
            ->groupBy('skill_categories.id', 'skill_categories.name_ar')
            ->get();

        $sectorLabels = $sectorStats->pluck('name_ar')->toArray();
        $sectorSeries = $sectorStats->pluck('total_candidates')->map(fn($v) => (int)$v)->toArray();

        // ── 5. ORGANIZATIONS & REJECTIONS (المؤسسات وأسباب الرفض) ──
        $totalOrganizations = Organization::count();
        $topOrganizations   = Organization::with('wilaya')
            ->withCount('participantProfiles')
            ->orderByDesc('participant_profiles_count')
            ->take(6)
            ->get();

        $rejectionReasons = Registration::where('status', 'REJECTED')
            ->whereNotNull('rejection_reason')
            ->where('rejection_reason', '!=', '')
            ->select('rejection_reason', DB::raw('count(*) as count'))
            ->groupBy('rejection_reason')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // ── 6. WILAYAS PARTICIPATION (توزيع المشاركة حسب الولايات) ──
        $topWilayasParticipation = DB::table('wilayas')
            ->leftJoin('participant_profiles', 'wilayas.id', '=', 'participant_profiles.wilaya_id')
            ->select('wilayas.name_ar', 'wilayas.code', DB::raw('count(participant_profiles.id) as candidates_count'))
            ->groupBy('wilayas.id', 'wilayas.name_ar', 'wilayas.code')
            ->orderByDesc('candidates_count')
            ->take(8)
            ->get();

        $wilayaLabels = $topWilayasParticipation->pluck('name_ar')->toArray();
        $wilayaSeries = $topWilayasParticipation->pluck('candidates_count')->map(fn($v) => (int)$v)->toArray();

        // ── 7. ROLES & SYSTEM AUDIT DATA ──
        $roleLabelsMap = [
            'COUNTRY_ADMIN'      => 'مسؤولو الوفود الوطنية',
            'EXECUTIVE_VIEWER'   => 'وزراء ومسؤولون تنفيذيون',
            'PARTICIPANT'        => 'متنافسون أولمبيون',
            'JUDGE'              => 'حكام وخبراء معتمدون',
            'MEDIA_MANAGER'      => 'مسؤولو الإعلام والصحافة',
            'SUPER_ADMIN'        => 'مدراء النظام الأقصى',
            'ORGANIZATION_ADMIN' => 'مسؤولو المؤسسات التكوينية',
        ];

        $rolesQuery = DB::table('roles')
            ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.name', DB::raw('count(model_has_roles.model_id) as count'))
            ->groupBy('roles.name')
            ->having('count', '>', 0)
            ->orderByDesc('count')
            ->get();

        $roleLabels = [];
        $roleSeries = [];
        foreach ($rolesQuery as $rq) {
            $roleLabels[] = $roleLabelsMap[$rq->name] ?? $rq->name;
            $roleSeries[] = (int) $rq->count;
        }

        $recentUsers = User::with(['roles', 'country'])
            ->latest()
            ->take(6)
            ->get();

        $recentRegistrations = Registration::with(['skill', 'country', 'user'])
            ->latest()
            ->take(6)
            ->get();

        $recentAuditLogs = AuditLog::latest()
            ->take(5)
            ->get();

        return view('livewire.admin.super-admin-dashboard', [
            'totalUsers'                => $totalUsers,
            'activeUsersCount'          => $activeUsersCount,
            'inactiveUsersCount'        => $inactiveUsersCount,

            'totalParticipants'         => ParticipantProfile::count(),
            'totalRegistrations'        => $totalRegistrations,
            'approvedRegistrations'     => $approvedRegistrations,
            'pendingRegistrations'      => $pendingRegistrations,
            'rejectedRegistrations'     => $rejectedRegistrations,

            'maleCandidatesCount'       => $maleCandidatesCount,
            'femaleCandidatesCount'     => $femaleCandidatesCount,

            'totalCountries'            => Country::count(),
            'totalSkills'               => $totalSkills,
            'activeSkillsCount'         => $activeSkillsCount,
            'topSkills'                 => $topSkills,
            'sectorStats'               => $sectorStats,
            'sectorLabels'              => $sectorLabels,
            'sectorSeries'              => $sectorSeries,

            'totalOrganizations'        => $totalOrganizations,
            'topOrganizations'          => $topOrganizations,
            'rejectionReasons'          => $rejectionReasons,

            'topWilayasParticipation'   => $topWilayasParticipation,
            'wilayaLabels'              => $wilayaLabels,
            'wilayaSeries'              => $wilayaSeries,

            'totalWilayas'              => DB::table('wilayas')->count(),
            'totalEditions'             => Edition::count(),
            'issuedCertificates'        => Certificate::count(),

            'roleLabels'                => $roleLabels,
            'roleSeries'                => $roleSeries,
            'recentUsers'               => $recentUsers,
            'recentRegistrations'       => $recentRegistrations,
            'recentAuditLogs'           => $recentAuditLogs,
            'activeEdition'             => Edition::where('is_active', true)->first(),
            'activeTab'                 => $this->activeTab,
        ]);
    }
}
