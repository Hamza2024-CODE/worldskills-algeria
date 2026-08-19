<?php

namespace App\Livewire\Auth;

use App\Enums\RoleEnum;
use App\Models\DelegationMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Login extends Component
{
    public $loginInput = '';
    public $password = '';
    public $remember = false;

    // Forgot Password / Account Recovery state
    public string $mode = 'login'; // 'login' or 'forgot'
    public int $recoveryStep = 1;  // 1: verify identity, 2: set new password
    public string $identityInput = '';
    public ?int $verifiedUserId = null;
    public string $verifiedUserName = '';
    public string $verifiedUserEmail = '';
    public string $newPassword = '';
    public string $newPasswordConfirmation = '';
    public string $recoverySuccessMessage = '';

    protected $rules = [
        'loginInput' => 'required|string',
        'password'   => 'required|min:6',
    ];

    protected $messages = [
        'loginInput.required' => 'يرجى إدخال البريد الإلكتروني أو اسم المستخدم.',
        'password.required'   => 'يرجى إدخال كلمة المرور.',
        'password.min'        => 'كلمة المرور يجب أن تتكون من 6 أحرف/أرقام على الأقل.',
    ];

    public function toggleForgotMode()
    {
        $this->mode = ($this->mode === 'login') ? 'forgot' : 'login';
        $this->reset(['identityInput', 'verifiedUserId', 'verifiedUserName', 'verifiedUserEmail', 'newPassword', 'newPasswordConfirmation', 'recoveryStep', 'recoverySuccessMessage']);
        $this->resetErrorBag();
    }

    public function verifyIdentity()
    {
        $isFr = app()->getLocale() === 'fr';
        $isEn = app()->getLocale() === 'en';

        $this->validate([
            'identityInput' => 'required|string|min:3',
        ], [
            'identityInput.required' => $isFr ? 'Veuillez saisir votre numéro NIN, passeport ou email.' : ($isEn ? 'Please enter your NIN, Passport, or Email.' : 'يرجى إدخال البريد الإلكتروني أو رقم NIN أو رقم جواز السفر.'),
            'identityInput.min'      => $isFr ? 'Identifiant trop court.' : ($isEn ? 'Identifier too short.' : 'معرف الحساب غير مكتمل.'),
        ]);

        $cleanId = trim($this->identityInput);

        // 1. Direct search on User by email, name, or phone
        $user = User::where('email', $cleanId)
                    ->orWhere('name', $cleanId)
                    ->orWhere('email', 'like', $cleanId . '@%')
                    ->first();

        // 2. Search in ParticipantProfile (national_id / passport_number / nin_number)
        if (!$user) {
            $user = User::whereHas('participant', function ($q) use ($cleanId) {
                $q->where('national_id', $cleanId)
                  ->orWhere('passport_number', $cleanId);

                if (\Illuminate\Support\Facades\Schema::hasColumn('participant_profiles', 'nin_number')) {
                    $q->orWhere('nin_number', $cleanId);
                }
            })->first();
        }

        // 3. Search in DelegationMember (nin_number / passport_number / national_id)
        if (!$user) {
            $member = DelegationMember::where(function ($q) use ($cleanId) {
                $q->where('nin_number', $cleanId)
                  ->orWhere('passport_number', $cleanId);

                if (\Illuminate\Support\Facades\Schema::hasColumn('delegation_members', 'national_id')) {
                    $q->orWhere('national_id', $cleanId);
                }
            })->first();

            if ($member) {
                $user = $member->user ?? User::where('email', $member->email)->first();
            }
        }

        // 4. Search in Registration by registration_number
        if (!$user) {
            $reg = \App\Models\Registration::where('registration_number', $cleanId)->first();
            if ($reg && $reg->participant) {
                $user = $reg->participant->user;
            }
        }

        // 5. Fallback: search by UUID
        if (!$user) {
            $user = User::where('uuid', $cleanId)->first();
        }

        if ($user) {
            $this->verifiedUserId   = $user->id;
            $this->verifiedUserName  = $user->name;
            $this->verifiedUserEmail = $user->email;
            $this->recoveryStep     = 2;
            $this->resetErrorBag();
        } else {
            $this->addError('identityInput', $isFr 
                ? 'Aucun compte trouvé correspondant à ces informations.' 
                : ($isEn 
                    ? 'No account found matching these details.' 
                    : 'لم يتم العثور على أي حساب مرتبط برقم التعريف أو البريد أو الجواز المدخل.'));
        }
    }

    public function resetPassword()
    {
        $isFr = app()->getLocale() === 'fr';
        $isEn = app()->getLocale() === 'en';

        $this->validate([
            'newPassword'             => 'required|min:6',
            'newPasswordConfirmation' => 'required|same:newPassword',
        ], [
            'newPassword.required'             => $isFr ? 'Veuillez saisir le nouveau mot de passe.' : ($isEn ? 'Please enter your new password.' : 'يرجى إدخال كلمة المرور الجديدة.'),
            'newPassword.min'                  => $isFr ? 'Le mot de passe doit contenir au moins 6 caractères.' : ($isEn ? 'New password must be at least 6 characters.' : 'كلمة المرور الجديدة يجب أن تتكون من 6 أحرف على الأقل.'),
            'newPasswordConfirmation.required' => $isFr ? 'Veuillez confirmer le mot de passe.' : ($isEn ? 'Please confirm the new password.' : 'يرجى تأكيد كلمة المرور الجديدة.'),
            'newPasswordConfirmation.same'     => $isFr ? 'La confirmation ne correspond pas au mot de passe.' : ($isEn ? 'Password confirmation does not match.' : 'تأكيد كلمة المرور غير مطابقة لكلمة المرور الجديدة.'),
        ]);

        if (!$this->verifiedUserId) {
            $this->recoveryStep = 1;
            return;
        }

        $user = User::find($this->verifiedUserId);
        if ($user) {
            $user->update([
                'password' => Hash::make($this->newPassword),
            ]);

            Auth::login($user, true);
            session()->regenerate();

            if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole(RoleEnum::MEDIA_MANAGER->value)) {
                return redirect()->route('admin.media.dashboard');
            } elseif ($user->hasRole(RoleEnum::EXECUTIVE_VIEWER->value)) {
                return redirect()->route('executive.dashboard');
            } elseif ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
                return redirect()->route('country.dashboard');
            } elseif ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
                return redirect()->route('organization.dashboard');
            } elseif ($user->hasRole(RoleEnum::JUDGE->value) || $user->hasRole(RoleEnum::EXPERT->value)) {
                return redirect()->route('judge.dashboard');
            }

            return redirect()->route('participant.dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        $input = trim($this->loginInput);
        $throttleKey = Str::lower($input) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('loginInput', app()->getLocale() === 'fr' 
                ? "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes." 
                : (app()->getLocale() === 'en' 
                    ? "Too many login attempts. Please try again in {$seconds} seconds." 
                    : "محاولات دخول كثيرة جداً. يرجى المحاولة بعد {$seconds} ثانية."));
            return;
        }

        // Find user by email or by username/name (e.g. admin, dz.admin, media, viewer)
        $user = User::where('email', $input)
                    ->orWhere('name', $input)
                    ->orWhere('email', 'like', $input . '@%')
                    ->first();

        if ($user && Hash::check($this->password, $user->password)) {
            Auth::login($user, $this->remember);
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole(RoleEnum::MEDIA_MANAGER->value)) {
                return redirect()->route('admin.media.dashboard');
            } elseif ($user->hasRole(RoleEnum::EXECUTIVE_VIEWER->value)) {
                return redirect()->route('executive.dashboard');
            } elseif ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
                return redirect()->route('country.dashboard');
            } elseif ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
                return redirect()->route('organization.dashboard');
            } elseif ($user->hasRole(RoleEnum::JUDGE->value) || $user->hasRole(RoleEnum::EXPERT->value)) {
                return redirect()->route('judge.dashboard');
            }

            return redirect()->route('participant.dashboard');
        }

        RateLimiter::hit($throttleKey, 60);

        $this->addError('loginInput', app()->getLocale() === 'fr' 
            ? 'Identifiants incorrects.' 
            : (app()->getLocale() === 'en' 
                ? 'Invalid login credentials.' 
                : 'اسم المستخدم/البريد الإلكتروني أو كلمة المرور غير صحيحة.'));
    }

    public function render()
    {
        return view('livewire.auth.login', [
            'mode'              => $this->mode,
            'recoveryStep'      => $this->recoveryStep,
            'verifiedUserName'  => $this->verifiedUserName,
            'verifiedUserEmail' => $this->verifiedUserEmail,
        ]);
    }
}
