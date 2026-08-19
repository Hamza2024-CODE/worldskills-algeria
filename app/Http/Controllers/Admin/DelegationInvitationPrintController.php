<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\Edition;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Http\Request;

class DelegationInvitationPrintController extends Controller
{
    public function printSingle(Request $request, $countryId)
    {
        $country = Country::findOrFail($countryId);
        $activeEdition = Edition::where('is_active', true)->first();

        $slug = strtolower($country->iso2 ?: 'af');
        $password = "WS2027#" . strtoupper($slug) . "!";

        $user = User::where('country_id', $country->id)
            ->whereHas('roles', fn($q) => $q->where('name', RoleEnum::COUNTRY_ADMIN->value))
            ->first();

        if (!$user) {
            $email = "{$slug}.admin@worldskills.africa";
            $user = User::where('email', $email)->first();
        }

        $delegation = CountryDelegation::where('country_id', $country->id)
            ->where('edition_id', $activeEdition?->id)
            ->first();

        $invitationData = [
            'country'    => $country,
            'user'       => $user,
            'email'      => $user?->email ?? "{$slug}.admin@worldskills.africa",
            'password'   => $password,
            'delegation' => $delegation,
            'login_url'  => url('/login'),
        ];

        return view('admin.delegation-invitations.print-single', [
            'invitation'    => $invitationData,
            'activeEdition' => $activeEdition,
        ]);
    }
}
