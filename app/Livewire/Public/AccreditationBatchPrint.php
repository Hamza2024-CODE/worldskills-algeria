<?php

namespace App\Livewire\Public;

use App\Enums\RoleEnum;
use App\Models\Badge;
use App\Models\Registration;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class AccreditationBatchPrint extends Component
{
    public array $users = [];
    public string $filterRole = '';
    public string $filterCountry = '';

    public function mount()
    {
        $user = auth()->user();
        if (!$user || !$user->hasAnyRole(['SUPER_ADMIN', 'NATIONAL_ADMIN', 'ORGANIZATION_ADMIN', 'COUNTRY_ADMIN'])) {
            abort(403, 'غير مصرح لك بإجراء طباعة الاعتمادات بالجملة.');
        }

        $ids = request()->query('ids');
        $role = request()->query('role');
        $countryId = request()->query('country_id');

        $this->filterRole = $role ?? '';
        $this->filterCountry = $countryId ?? '';

        if ($ids) {
            $idArray = explode(',', $ids);
            $this->users = User::with(['roles', 'country', 'organization', 'participant.registrations', 'badges'])
                ->whereIn('id', $idArray)
                ->get()
                ->all();
        } else {
            $query = User::with(['roles', 'country', 'organization', 'participant.registrations', 'badges'])
                ->where('is_active', true);
            
            if ($this->filterRole) {
                $roleMap = [
                    'COMPETITOR'      => [RoleEnum::PARTICIPANT->value],
                    'DELEGATION HEAD' => [RoleEnum::COUNTRY_ADMIN->value],
                    'EXPERT JUDGE'    => [RoleEnum::JUDGE->value],
                    'MEDIA'           => [RoleEnum::MEDIA_MANAGER->value],
                    'VIP'             => [RoleEnum::EXECUTIVE_VIEWER->value],
                    'ORGANIZER'       => [RoleEnum::ORGANIZATION_ADMIN->value, RoleEnum::SUPER_ADMIN->value],
                ];

                if (isset($roleMap[$this->filterRole])) {
                    $query->whereHas('roles', fn($r) => $r->whereIn('name', $roleMap[$this->filterRole]));
                } else {
                    $query->whereHas('badges', fn($b) => $b->where('role_title', $this->filterRole));
                }
            }

            if ($this->filterCountry) {
                $query->where(function ($q) {
                    $q->where('country_id', $this->filterCountry)
                      ->orWhereHas('participant.registrations', fn($r) => $r->where('country_id', $this->filterCountry));
                });
            }

            $this->users = $query->take(250)->get()->all();
        }
    }

    public function render()
    {
        return view('livewire.public.accreditation-batch-print');
    }
}
