<?php

namespace App\Livewire\Admin;

use App\Models\Badge;
use App\Models\Country;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class BulkAccreditationBadgesPrint extends Component
{
    public string $filterRole = 'ALL';
    public string $filterCountry = '';
    public array $badgeItems = [];

    public function mount()
    {
        $this->filterRole = request()->get('role', 'ALL');
        $this->filterCountry = request()->get('country', '');
        $selectedIds = request()->get('ids', '');

        $query = User::with(['roles', 'country', 'participant.registrations.skill', 'badges']);

        if (!empty($selectedIds)) {
            $ids = array_filter(explode(',', $selectedIds));
            $query->whereIn('id', $ids);
        } else {
            if ($this->filterRole !== 'ALL') {
                $roleMap = [
                    'COMPETITOR'      => ['PARTICIPANT'],
                    'DELEGATION HEAD' => ['COUNTRY_ADMIN'],
                    'EXPERT JUDGE'    => ['JUDGE', 'EXPERT'],
                    'MEDIA'           => ['MEDIA_MANAGER'],
                    'VIP'             => ['EXECUTIVE_VIEWER'],
                    'ORGANIZER'       => ['ORGANIZATION_ADMIN', 'SUPER_ADMIN', 'NATIONAL_ADMIN'],
                ];

                if (isset($roleMap[$this->filterRole])) {
                    $query->whereHas('roles', fn($r) => $r->whereIn('name', $roleMap[$this->filterRole]));
                }
            }

            if (!empty($this->filterCountry)) {
                $query->where('country_id', $this->filterCountry);
            }
        }

        $users = $query->orderBy('name')->get();

        $this->badgeItems = [];
        foreach ($users as $user) {
            $userRole = $user->roles->first()?->name;
            $roleTitle = match ($userRole) {
                'EXECUTIVE_VIEWER'                  => 'MINISTERIAL EXECUTIVE OBSERVER',
                'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
                'MEDIA_MANAGER'                     => 'MEDIA',
                'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                default                             => 'COMPETITOR',
            };

            $badge = Badge::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'badge_uuid'   => (string) Str::uuid(),
                    'access_token' => Str::random(32),
                    'role_title'   => $roleTitle,
                    'status'       => 'ACTIVE',
                ]
            );

            $reg = Registration::with(['participant', 'country', 'skill'])
                ->whereHas('participant', fn($p) => $p->where('user_id', $user->id))
                ->latest()
                ->first();

            $token = $badge->access_token;
            $verifyUrl = route('verify', ['token' => $token]);
            $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 250);

            $nameAr = $reg?->participant?->first_name_ar ? ($reg->participant->first_name_ar . ' ' . $reg->participant->last_name_ar) : $user->name;
            $nameLatin = $reg?->participant?->first_name_latin ? ($reg->participant->first_name_latin . ' ' . $reg->participant->last_name_latin) : ($user->email ?? 'Accredited Member');

            $this->badgeItems[] = [
                'id'         => $user->id,
                'user'       => $user,
                'roleTitle'  => $roleTitle,
                'token'      => $token,
                'qrCodeUrl'  => $qrCodeUrl,
                'nameAr'     => $nameAr,
                'nameLatin'  => $nameLatin,
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.accreditations.bulk-print', [
            'countries' => Country::orderBy('name_ar')->get(),
        ]);
    }
}
