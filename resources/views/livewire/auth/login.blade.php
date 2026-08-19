@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) {
        'fr' => $fr,
        'en' => $en,
        default => $ar
    };
@endphp

<div class="min-h-screen bg-[#F4F7FC] flex flex-col justify-between py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    
    <!-- Top Bar: Back Link & Language Switcher -->
    <div class="max-w-4xl w-full mx-auto flex items-center justify-between z-50">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-brand-500 bg-white px-4 py-2 rounded-2xl transition border border-slate-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4 rtl:rotate-180 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>{{ __('messages.back_to_main_portal') }}</span>
        </a>

        <div class="bg-white px-3 py-1.5 rounded-2xl border border-slate-200 shadow-sm">
            <x-language-switcher />
        </div>
    </div>

    <!-- Background Radial Glows -->
    <div class="absolute top-0 right-1/4 w-[30rem] h-[30rem] bg-brand-200/50 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-[30rem] h-[30rem] bg-sky-200/50 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Card Container -->
    <div class="max-w-4xl w-full mx-auto my-auto bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10">
        
        <!-- Left Branding Panel: Signature Light Blue Gradient -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#0052CC] via-[#0066FF] to-[#00A3FF] p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="space-y-6 relative z-10">
                <div class="space-y-5">
                    <div class="flex items-center gap-3">
                        <img src="/logo.svg" alt="WorldSkills Algeria" class="h-12 w-auto filter drop-shadow-md">
                        <div>
                            <span class="font-black text-xl text-white leading-none block">WorldSkills Algeria</span>
                            <span class="text-[10px] font-extrabold text-blue-100 block mt-1 uppercase tracking-wider">
                                {{ $t('الدورة الوطنية 2026', 'Édition Nationale 2026', 'National Edition 2026') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <h2 class="text-2xl font-black leading-tight text-white">
                            {{ __('messages.olympiad_title') }}
                        </h2>
                        <p class="text-xs text-blue-100 leading-relaxed font-medium">
                            {{ __('messages.login_branding_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Form Container (Login or Recovery Mode) -->
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center space-y-7 bg-white text-slate-900" x-data="{ showPassword: false }">
            
            @if($mode === 'login')
                {{-- ── 1. REGULAR LOGIN FORM ── --}}
                <div class="space-y-2">
                    <h3 class="text-2xl font-black text-[#06205C]">
                        {{ __('messages.login_heading') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ __('messages.login_subheading') }}
                    </p>
                </div>

                <form wire:submit.prevent="login" class="space-y-5">
                    
                    <!-- Email or Username -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">
                            {{ __('messages.email_or_username') }}
                        </label>
                        <input type="text" 
                               wire:model="loginInput" 
                               required 
                               placeholder="{{ __('messages.email_or_username_placeholder') }}" 
                               class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition shadow-sm">
                        @error('loginInput') 
                            <span class="text-[10px] text-rose-600 font-bold block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Password with Toggle -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">
                            {{ __('messages.password_label') }}
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   wire:model="password" 
                                   required 
                                   placeholder="••••••••" 
                                   class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition shadow-sm">
                            
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 end-0 pe-4 flex items-center text-slate-400 hover:text-brand-500 text-xs font-bold transition">
                                <span x-text="showPassword ? '{{ $t('إخفاء', 'Masquer', 'Hide') }}' : '{{ $t('إظهار', 'Afficher', 'Show') }}'"></span>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-[10px] text-rose-600 font-bold block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password Link -->
                    <div class="flex items-center justify-between gap-2 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="remember" class="rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                            <span class="text-xs font-bold text-slate-600">
                                {{ __('messages.remember_me') }}
                            </span>
                        </label>

                        <button type="button" wire:click="toggleForgotMode" class="text-xs font-black text-blue-600 hover:text-blue-700 hover:underline transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                            <span>{{ $t('نسيت كلمة المرور؟', 'Mot de passe oublié ?', 'Forgot Password?') }}</span>
                        </button>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-[#0052CC] via-[#0066FF] to-[#00A3FF] hover:from-[#003999] hover:to-[#0066FF] text-white font-bold text-xs shadow-xl shadow-brand-500/25 transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>{{ __('messages.login_button') }}</span>
                    </button>
                </form>

            @else
                {{-- ── 2. FORGOT PASSWORD / IDENTITY RECOVERY FORM ── --}}
                <div class="space-y-4">
                    <button type="button" wire:click="toggleForgotMode" class="text-xs font-black text-slate-500 hover:text-slate-800 transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 rtl:rotate-180 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>{{ $t('العودة إلى صفحة تسجيل الدخول', 'Retour à la connexion', 'Back to Sign In') }}</span>
                    </button>

                    <div class="space-y-1">
                        <h3 class="text-2xl font-black text-[#06205C] flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                            <span>{{ $t('استرجاع الحساب وكلمة المرور', 'Récupération de Compte & Mot de Passe', 'Account & Password Recovery') }}</span>
                        </h3>
                        <p class="text-xs text-slate-500 font-bold leading-relaxed">
                            {{ $t('أدخل رقم التعريف الوطني (NIN) أو رقم جواز السفر الدولي المسجل بحسابك للتحقق من ملكية الحساب وإعادة تعيين كلمة السر.', 'Entrez votre numéro NIN ou passeport enregistré pour vérifier votre compte et réinitialiser votre mot de passe.', 'Enter your registered NIN or Passport number to verify account ownership and reset your password.') }}
                        </p>
                    </div>
                </div>

                @if($recoveryStep === 1)
                    {{-- STEP 1: IDENTITY VERIFICATION --}}
                    <form wire:submit.prevent="verifyIdentity" class="space-y-5">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black text-slate-700">
                                {{ $t('رقم التعريف الوطني (NIN) أو رقم جواز السفر الدولي *', 'Numéro NIN ou Numéro de Passeport *', 'National ID (NIN) or Passport Number *') }}
                            </label>
                            <input type="text" 
                                   wire:model="identityInput" 
                                   required 
                                   placeholder="{{ $t('أدخل الرقم المسجل بحسابك (مثال: 1000200300... أو DZ-1234567)', 'Exemple : 1000200300... ou DZ-1234567', 'Example: 1000200300... or DZ-1234567') }}" 
                                   class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition shadow-sm">
                            @error('identityInput') 
                                <div class="flex items-center gap-1.5 text-xs text-rose-600 font-black mt-1">
                                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-xl transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>{{ $t('التحقق من صحة وثيقة الهوية', 'Vérifier l\'Identité', 'Verify Identity Document') }}</span>
                        </button>
                    </form>

                @else
                    {{-- STEP 2: NEW PASSWORD SETTING --}}
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold space-y-1 shadow-xs animate-fade-in">
                        <div class="flex items-center gap-2 font-black text-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $t('تم التثبت بنجاح من ملكية الحساب!', 'Propriété du compte vérifiée avec succès !', 'Account ownership verified successfully!') }}</span>
                        </div>
                        <p class="text-[11px] text-slate-600">
                            {{ $t('صاحب الحساب:', 'Titulaire du compte :', 'Account Holder:') }} <strong class="text-slate-900">{{ $verifiedUserName }}</strong> ({{ $verifiedUserEmail }})
                        </p>
                    </div>

                    <form wire:submit.prevent="resetPassword" class="space-y-5">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-black text-slate-700">
                                {{ $t('كلمة المرور الجديدة *', 'Nouveau Mot de Passe *', 'New Password *') }}
                            </label>
                            <input type="password" 
                                   wire:model="newPassword" 
                                   required 
                                   placeholder="••••••••" 
                                   class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition shadow-sm">
                            @error('newPassword') 
                                <span class="text-xs text-rose-600 font-bold block mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-black text-slate-700">
                                {{ $t('تأكيد كلمة المرور الجديدة *', 'Confirmer le Nouveau Mot de Passe *', 'Confirm New Password *') }}
                            </label>
                            <input type="password" 
                                   wire:model="newPasswordConfirmation" 
                                   required 
                                   placeholder="••••••••" 
                                   class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition shadow-sm">
                            @error('newPasswordConfirmation') 
                                <span class="text-xs text-rose-600 font-bold block mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#06205C] hover:bg-blue-900 text-white font-black text-xs shadow-xl transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>{{ $t('تحديث كلمة المرور وتسجيل الدخول', 'Mettre à jour & Se connecter', 'Update Password & Sign In') }}</span>
                        </button>
                    </form>
                @endif

            @endif

        </div>

    </div>
</div>
