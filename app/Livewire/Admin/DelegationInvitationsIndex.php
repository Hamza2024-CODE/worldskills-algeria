<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\Edition;
use App\Models\User;
use App\Enums\RoleEnum;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class DelegationInvitationsIndex extends Component
{
    public string $search = '';
    public ?int $selectedCountryId = null;
    public bool $showPrintModal = false;

    public function render()
    {
        $activeEdition = Edition::where('is_active', true)->first();

        $query = Country::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name_ar', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('name_en', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('name_fr', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('iso2', 'LIKE', '%' . $this->search . '%');
            });
        }

        $countries = $query->orderBy('name_ar')->get();

        // Attach delegation user and password info to each country
        $delegationsData = $countries->map(function ($c) use ($activeEdition) {
            $slug = strtolower($c->iso2 ?: 'af');
            $password = "WS2027#" . strtoupper($slug) . "!";

            $user = User::where('country_id', $c->id)
                ->whereHas('roles', fn($q) => $q->where('name', RoleEnum::COUNTRY_ADMIN->value))
                ->first();

            if (!$user) {
                $email = "{$slug}.admin@worldskills.africa";
                $user = User::where('email', $email)->first();
            }

            $delegation = CountryDelegation::where('country_id', $c->id)
                ->where('edition_id', $activeEdition?->id)
                ->first();

            return [
                'country'      => $c,
                'user'         => $user,
                'email'        => $user?->email ?? "{$slug}.admin@worldskills.africa",
                'password'     => $password,
                'delegation'   => $delegation,
                'login_url'    => url('/login'),
            ];
        });

        $selectedInvitation = null;
        if ($this->selectedCountryId) {
            $selectedInvitation = $delegationsData->firstWhere('country.id', $this->selectedCountryId);
        }

        return view('livewire.admin.delegation-invitations-index', [
            'delegationsData'    => $delegationsData,
            'selectedInvitation' => $selectedInvitation,
            'activeEdition'      => $activeEdition,
            'totalCount'         => $countries->count(),
        ]);
    }

    public function openPrintModal(int $countryId)
    {
        $this->selectedCountryId = $countryId;
        $this->showPrintModal = true;
    }
}
