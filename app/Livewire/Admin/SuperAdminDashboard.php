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
        // ── 1. USERS & ROLES STATS (دائرة نسبية) ──
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

        // ── 2. SKILLS BY CATEGORY STATS (أعمدة بيانية) ──
        $skillsQuery = DB::table('skill_categories')
            ->leftJoin('skills', 'skill_categories.id', '=', 'skills.category_id')
            ->select('skill_categories.name_ar', DB::raw('count(skills.id) as count'))
            ->groupBy('skill_categories.id', 'skill_categories.name_ar')
            ->having('count', '>', 0)
            ->orderByDesc('count')
            ->get();

        $skillLabels = $skillsQuery->pluck('name_ar')->toArray();
        $skillSeries = $skillsQuery->pluck('count')->map(fn($v) => (int)$v)->toArray();

        // ── 3. TOP WILAYAS STATS (أعمدة أفقية لتوزيع المؤسسات) ──
        $wilayasQuery = DB::table('wilayas')
            ->leftJoin('organizations', 'wilayas.id', '=', 'organizations.wilaya_id')
            ->select('wilayas.name_ar', DB::raw('count(organizations.id) as count'))
            ->groupBy('wilayas.id', 'wilayas.name_ar')
            ->orderByDesc('count')
            ->take(7)
            ->get();

        $wilayaLabels = $wilayasQuery->pluck('name_ar')->toArray();
        $wilayaSeries = $wilayasQuery->pluck('count')->map(fn($v) => (int)$v)->toArray();

        // ── 4. RECENT COLLECTIONS ──
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

        $recentDiplomaticMeetings = DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room'])
            ->where('status', '!=', 'CANCELLED')
            ->orderBy('start_time', 'asc')
            ->take(4)
            ->get();

        // ── 5. SPECIALTY COUNTS FROM ALL TABLES ──
        $cisCriteriaCount       = DB::table('competition_assessment_criteria')->count();
        $cisModulesCount        = DB::table('competition_assessment_modules')->count();
        $auditLogsCount         = DB::table('audit_logs')->count();
        $videosCount            = DB::table('videos')->count();
        $mediaCount             = DB::table('media')->count();
        $albumsCount            = DB::table('albums')->count();
        $partnersCount          = DB::table('partners')->count();
        $delegationMembersCount = DB::table('delegation_members')->count();
        $arrivalsCount          = DB::table('delegation_arrivals')->count();
        $accessDecisionsCount   = DB::table('wsap_access_decisions')->count();
        $newsArticlesCount      = DB::table('news_articles')->count();
        $badgesCount            = DB::table('badges')->count();

        return view('livewire.admin.super-admin-dashboard', [
            'totalUsers'                => User::count(),
            'totalParticipants'         => ParticipantProfile::count(),
            'totalRegistrations'        => Registration::count(),
            'pendingRegistrations'      => Registration::where('status', 'PENDING')->count(),
            'approvedRegistrations'     => Registration::where('status', 'APPROVED')->count(),
            'totalCountries'            => Country::count(),
            'totalSkills'               => Skill::count(),
            'totalOrganizations'        => Organization::count(),
            'totalWilayas'              => DB::table('wilayas')->count(),
            'totalEditions'             => Edition::count(),
            'issuedCertificates'        => Certificate::count(),
            'totalMinisters'            => MinisterialOfficial::count(),
            'availableMinisters'        => MinisterialOfficial::where('availability_status', 'AVAILABLE')->count(),
            'todayDiplomaticMeetings'   => DiplomaticMeeting::whereDate('start_time', now()->toDateString())->count(),

            // Specialty Counts
            'cisCriteriaCount'          => $cisCriteriaCount,
            'cisModulesCount'           => $cisModulesCount,
            'auditLogsCount'            => $auditLogsCount,
            'videosCount'               => $videosCount,
            'mediaCount'                => $mediaCount,
            'albumsCount'               => $albumsCount,
            'partnersCount'             => $partnersCount,
            'delegationMembersCount'    => $delegationMembersCount,
            'arrivalsCount'             => $arrivalsCount,
            'accessDecisionsCount'      => $accessDecisionsCount,
            'newsArticlesCount'         => $newsArticlesCount,
            'badgesCount'               => $badgesCount,

            // Charts Data
            'roleLabels'                => $roleLabels,
            'roleSeries'                => $roleSeries,
            'skillLabels'               => $skillLabels,
            'skillSeries'               => $skillSeries,
            'wilayaLabels'              => $wilayaLabels,
            'wilayaSeries'              => $wilayaSeries,

            'recentUsers'               => $recentUsers,
            'recentRegistrations'       => $recentRegistrations,
            'recentAuditLogs'           => $recentAuditLogs,
            'recentDiplomaticMeetings'  => $recentDiplomaticMeetings,
            'activeEdition'             => Edition::where('is_active', true)->first(),
            'activeTab'                 => $this->activeTab,
        ]);
    }
}
