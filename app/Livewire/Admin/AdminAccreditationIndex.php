<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\AccreditationZone;
use App\Models\Badge;
use App\Models\Country;
use App\Models\Skill;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminAccreditationIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterRole    = '';
    public string $filterCountry = '';
    public string $filterSkill   = '';
    public string $filterWilaya  = '';
    public string $filterStatus = '';

    // Checkbox multi-selection
    public array  $selectedUsers = [];
    public bool   $selectAll     = false;

    // Issue Badge Modal
    public bool   $formOpen       = false;
    public int    $user_id_badge  = 0;
    public string $role_title     = 'COMPETITOR';
    public array  $selected_zones = [1, 4]; // Default Z1 & Z4
    public string $valid_until    = '';

    // Edit Zones Modal
    public bool   $editZonesOpen        = false;
    public ?int   $editingUserId        = null;
    public array  $userEditingZoneIds   = [];

    protected $queryString = [
        'search', 'filterRole', 'filterCountry', 'filterSkill', 'filterWilaya', 'filterStatus'
    ];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterRole(): void    { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterSkill(): void   { $this->resetPage(); }
    public function updatingFilterWilaya(): void  { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedUsers = $this->getFilteredUsersQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function clearSelection(): void
    {
        $this->selectedUsers = [];
        $this->selectAll     = false;
    }

    public function openCreate(): void
    {
        $this->reset(['user_id_badge', 'role_title', 'selected_zones', 'valid_until']);
        $this->role_title     = 'COMPETITOR';
        $this->selected_zones = [1, 4];
        $this->formOpen       = true;
    }

    public function issue(): void
    {
        $this->validate([
            'user_id_badge' => 'required|integer|min:1',
            'role_title'    => 'required|string',
        ]);

        Badge::updateOrCreate(
            ['user_id' => $this->user_id_badge],
            [
                'badge_uuid'       => (string) Str::uuid(),
                'access_token'     => Str::random(32),
                'role_title'       => $this->role_title,
                'allowed_zone_ids' => $this->selected_zones,
                'status'           => 'ACTIVE',
                'valid_until'      => $this->valid_until ?: null,
            ]
        );

        $this->formOpen = false;
        session()->flash('success', 'تم إصدار وتوثيق شارة الاعتماد بنجاح.');
    }

    public function openEditZones(int $userId): void
    {
        $this->editingUserId = $userId;
        $user = User::with('badges')->findOrFail($userId);
        $badge = $user->badges->first();
        $this->userEditingZoneIds = $badge?->allowed_zone_ids ?? [1, 4];
        $this->editZonesOpen = true;
    }

    public function saveUserZones(): void
    {
        if (!$this->editingUserId) return;

        $badge = Badge::firstOrNew(['user_id' => $this->editingUserId]);
        if (!$badge->exists) {
            $user = User::with('roles')->find($this->editingUserId);
            $badge->badge_uuid   = (string) Str::uuid();
            $badge->access_token = Str::random(32);
            $badge->role_title   = $user?->roles->first()?->name ?? 'COMPETITOR';
            $badge->status       = 'ACTIVE';
        }
        $badge->allowed_zone_ids = array_map('intval', $this->userEditingZoneIds);
        $badge->save();

        $this->editZonesOpen = false;
        $this->editingUserId = null;
        session()->flash('success', 'تم تحديث المناطق الأمنية المسموحة للبطاقة بنجاح.');
    }

    public function toggleBlockUser(int $userId): void
    {
        $user = User::with('badges')->findOrFail($userId);
        $badge = $user->badges->first();

        if ($badge) {
            $newStatus = ($badge->status === 'BLOCKED') ? 'ACTIVE' : 'BLOCKED';
            $badge->update(['status' => $newStatus]);
            session()->flash('success', $newStatus === 'BLOCKED' ? 'تم تعليق وحظر البطاقة.' : 'تم تفعيل البطاقة وإعادة اعتمادها.');
        } else {
            // Create blocked badge
            Badge::create([
                'user_id'          => $userId,
                'badge_uuid'       => (string) Str::uuid(),
                'access_token'     => Str::random(32),
                'role_title'       => $user->roles->first()?->name ?? 'PARTICIPANT',
                'allowed_zone_ids' => [],
                'status'           => 'BLOCKED',
            ]);
            session()->flash('success', 'تم حظر البطاقة وتعليق الاعتماد.');
        }
    }

    /* ─── Export Accredited Users to CSV ─── */
    public function exportExcel()
    {
        $users = $this->getFilteredUsersQuery()->latest()->get();

        $csvData = [];
        $csvData[] = [
            'ID',
            'الاسم بالعربية',
            'الاسم باللاتينية',
            'البريد الإلكتروني',
            'رقم التسجيل / الشارة',
            'الدور المعتمد',
            'الدولة / الوفد',
            'التخصص / المؤسسة',
            'الولاية',
            'حالة البطاقة',
            'المناطق الأمنية المسموحة'
        ];

        foreach ($users as $u) {
            $reg         = $u->participant?->registrations->first();
            $badge       = $u->badges->first();
            $nameAr      = $u->participant?->first_name_ar ? ($u->participant->first_name_ar . ' ' . $u->participant->last_name_ar) : $u->name;
            $nameLatin   = $u->participant?->first_name_latin ? ($u->participant->first_name_latin . ' ' . $u->participant->last_name_latin) : $u->email;
            $regNumber   = $reg?->registration_number ?? ($badge?->badge_uuid ? substr($badge->badge_uuid, 0, 18) : ('USR-' . str_pad($u->id, 5, '0', STR_PAD_LEFT)));
            $countryName = $reg?->country?->name_ar ?? $u->country?->name_ar ?? 'الجزائر';
            $skillOrOrg  = $reg?->skill?->name_ar ?? $u->organization?->name_ar ?? 'المنصة الوطنية';
            $roleTitle   = $badge?->role_title ?? $u->roles->first()?->name ?? 'PARTICIPANT';
            $status      = $badge?->status ?? 'ACTIVE';

            $zonesText = 'Z1, Z4';
            if ($badge && !empty($badge->allowed_zone_ids)) {
                $zonesText = 'Z' . implode(', Z', $badge->allowed_zone_ids);
            }

            $csvData[] = [
                $u->id,
                $nameAr,
                $nameLatin,
                $u->email,
                $regNumber,
                $roleTitle,
                $countryName,
                $skillOrOrg,
                $u->wilaya?->name_ar ?? '—',
                $status === 'BLOCKED' ? 'موقوف / محظور' : 'مفعل ومعتمد',
                $zonesText,
            ];
        }

        $filename = 'WSAP_Accreditations_Badges_' . date('Y_m_d_His') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getFilteredUsersQuery()
    {
        return User::with([
            'roles',
            'country',
            'organization',
            'wilaya',
            'participant.registrations.skill',
            'participant.registrations.country',
            'badges'
        ])
        ->where('is_active', true)
        ->when($this->search, function ($q) {
            $s = '%' . $this->search . '%';
            $q->where(function ($sub) use ($s) {
                $sub->where('name', 'like', $s)
                    ->orWhere('email', 'like', $s)
                    ->orWhereHas('participant', fn($p) =>
                        $p->where('first_name_ar', 'like', $s)
                          ->orWhere('last_name_ar', 'like', $s)
                          ->orWhere('first_name_latin', 'like', $s)
                          ->orWhere('last_name_latin', 'like', $s)
                          ->orWhereHas('registrations', fn($r) => $r->where('registration_number', 'like', $s))
                    )
                    ->orWhereHas('badges', fn($b) => $b->where('badge_uuid', 'like', $s))
                    ->orWhereHas('country', fn($c) => $c->where('name_ar', 'like', $s)->orWhere('name_en', 'like', $s));
            });
        })
        ->when($this->filterRole, function ($q) {
            $roleMap = [
                'COMPETITOR'      => [RoleEnum::PARTICIPANT->value],
                'DELEGATION HEAD' => [RoleEnum::COUNTRY_ADMIN->value],
                'EXPERT JUDGE'    => [RoleEnum::JUDGE->value],
                'MEDIA'           => [RoleEnum::MEDIA_MANAGER->value],
                'VIP'             => [RoleEnum::EXECUTIVE_VIEWER->value],
                'ORGANIZER'       => [RoleEnum::ORGANIZATION_ADMIN->value, RoleEnum::SUPER_ADMIN->value],
            ];

            if (isset($roleMap[$this->filterRole])) {
                $q->where(function($sub) use ($roleMap) {
                    $sub->whereHas('roles', fn($r) => $r->whereIn('name', $roleMap[$this->filterRole]))
                        ->orWhereHas('badges', fn($b) => $b->where('role_title', $this->filterRole));
                });
            } else {
                $q->whereHas('badges', fn($b) => $b->where('role_title', $this->filterRole));
            }
        })
        ->when($this->filterCountry, function ($q) {
            $q->where(function($sub) {
                $sub->where('country_id', $this->filterCountry)
                    ->orWhereHas('participant.registrations', fn($r) => $r->where('country_id', $this->filterCountry));
            });
        })
        ->when($this->filterSkill, function ($q) {
            $q->whereHas('participant.registrations', fn($r) => $r->where('skill_id', $this->filterSkill));
        })
        ->when($this->filterWilaya, function ($q) {
            $q->where('wilaya_id', $this->filterWilaya);
        })
        ->when($this->filterStatus, function ($q) {
            if ($this->filterStatus === 'BLOCKED') {
                $q->whereHas('badges', fn($b) => $b->where('status', 'BLOCKED'));
            } elseif ($this->filterStatus === 'ACTIVE') {
                $q->where(function($sub) {
                    $sub->whereDoesntHave('badges')
                        ->orWhereHas('badges', fn($b) => $b->where('status', 'ACTIVE'));
                });
            }
        });
    }

    public function render()
    {
        $users = $this->getFilteredUsersQuery()->orderByDesc('created_at')->paginate(12);

        return view('livewire.admin.accreditations.index', [
            'users'        => $users,
            'allUsers'     => User::where('is_active', true)->orderBy('name')->take(100)->get(),
            'countries'    => Country::orderBy('name_ar')->get(),
            'skills'       => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'wilayas'      => Wilaya::orderBy('code')->get(),
            'zones'        => AccreditationZone::orderBy('id')->get(),
            'totalUsers'   => User::where('is_active', true)->count(),
            'competitorCount' => User::whereHas('roles', fn($r) => $r->where('name', RoleEnum::PARTICIPANT->value))->count(),
            'vipCount'     => User::whereHas('roles', fn($r) => $r->whereIn('name', [RoleEnum::EXECUTIVE_VIEWER->value, RoleEnum::COUNTRY_ADMIN->value]))->count(),
            'zonesCount'   => AccreditationZone::count(),
        ]);
    }
}
