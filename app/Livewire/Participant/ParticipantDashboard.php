<?php

namespace App\Livewire\Participant;

use App\Enums\DateType;
use App\Models\DelegationMember;
use App\Models\Edition;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Services\DateEngine;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class ParticipantDashboard extends Component
{
    public $registration;
    public $profile;
    public $countdown = [];
    public int $journeyStep = 3;

    public bool $showSizeModal = false;
    public string $editSuitSize = 'M';
    public string $editShoeSize = '42';
    public string $editHeightCm = '175';
    public string $successMessage = '';

    public function mount(DateEngine $dateEngine, ?int $targetParticipantId = null)
    {
        $user = Auth::user();

        if ($user) {
            // Scope strictly to current authenticated candidate
            $this->profile = ParticipantProfile::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if ($targetParticipantId && $this->profile && $targetParticipantId !== $this->profile->id && !$user->hasRole('SUPER_ADMIN')) {
                throw new AuthorizationException('Cross-participant profile access denied.');
            }

            // Sync user_id if missing
            if ($this->profile && !$this->profile->user_id) {
                $this->profile->update(['user_id' => $user->id]);
            }

            // Auto-create ParticipantProfile if missing for PARTICIPANT user
            if (!$this->profile && $user->hasRole('PARTICIPANT')) {
                $nameParts = explode(' ', trim($user->name));
                $firstName = $nameParts[0] ?? 'المتنافس';
                $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'الأولمبي';
                $this->profile = ParticipantProfile::create([
                    'user_id'       => $user->id,
                    'first_name_ar' => $firstName,
                    'last_name_ar'  => $lastName,
                    'email'         => $user->email,
                    'phone'         => '0550000000',
                    'country_id'    => $user->country_id ?: 1,
                    'wilaya_id'     => $user->wilaya_id,
                ]);
            }

            if ($this->profile) {
                $this->registration = Registration::with(['skill', 'country', 'documents', 'edition', 'wilaya', 'organization'])
                    ->where('participant_id', $this->profile->id)
                    ->latest()
                    ->first();
            }

            // Fallback: search registration linked by email/user if profile record hasn't linked participant_id yet
            if (!$this->registration) {
                $this->registration = Registration::with(['skill', 'country', 'documents', 'edition', 'wilaya', 'organization'])
                    ->whereHas('participant', function($q) use ($user) {
                        $q->where('user_id', $user->id)->orWhere('email', $user->email);
                    })
                    ->latest()
                    ->first();

                if ($this->registration && $this->registration->participant) {
                    $this->profile = $this->registration->participant;
                }
            }

            // Auto-create Registration if missing for this profile
            if ($this->profile && !$this->registration) {
                $activeEdition = Edition::where('is_active', true)->first();
                $firstSkill = \App\Models\Skill::where('is_active', true)->first();
                $this->registration = Registration::create([
                    'participant_id' => $this->profile->id,
                    'edition_id'     => $activeEdition?->id,
                    'country_id'     => $this->profile->country_id ?: ($user->country_id ?: 1),
                    'skill_id'       => $this->profile->skill_id ?: ($firstSkill?->id ?: 1),
                    'suit_size'      => 'M',
                    'shoe_size'      => '42',
                    'height_cm'      => 175,
                    'status'         => \App\Enums\ParticipantStatus::PENDING,
                    'submitted_at'   => now(),
                ]);
                $this->registration->load(['skill', 'country', 'documents', 'edition', 'wilaya', 'organization']);
            }

            // Initialize size values
            if ($this->registration) {
                $this->editSuitSize = $this->registration->suit_size ?: 'M';
                $this->editShoeSize = $this->registration->shoe_size ?: '42';
                $this->editHeightCm = (string) ($this->registration->height_cm ?: 175);
            }
        }

        $edition = Edition::where('is_active', true)->first();
        if ($edition) {
            $this->countdown = $dateEngine->timeRemainingFormatted($edition->id, DateType::REGISTRATION);
        }
    }

    public function updateSizes(): void
    {
        $user = Auth::user();
        $locale = app()->getLocale();

        if ($this->registration) {
            $this->registration->update([
                'suit_size' => $this->editSuitSize,
                'shoe_size' => $this->editShoeSize,
                'height_cm' => (int) $this->editHeightCm,
            ]);
        }

        if ($user) {
            DelegationMember::where('user_id', $user->id)->update([
                'suit_size' => $this->editSuitSize,
                'shoe_size' => $this->editShoeSize,
            ]);
        }

        $this->showSizeModal = false;
        $this->successMessage = $locale === 'fr' 
            ? 'Vos tailles d\'équipement ont été mises à jour avec succès.' 
            : ($locale === 'en' 
                ? 'Your equipment sizes have been updated successfully.' 
                : 'تم تحديث مقاسات البدلة الرسمية والتجهيزات اللوجستية بنجاح.');
    }

    public function render()
    {
        return view('livewire.participant.participant-dashboard');
    }
}
