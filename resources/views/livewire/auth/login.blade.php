@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) {
        'fr' => $fr,
        'en' => $en,
        default => $ar
    };
@endphp

<div class="relative w-full min-h-[calc(100vh-140px)] flex items-center justify-center py-6 sm:py-12 px-4 sm:px-6 lg:px-8 overflow-hidden" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    

    

    <!-- MAIN HORIZONTAL SPLIT CARD (مطابق تماماً للتصميم المرجعي Freepik) -->
    <div class="w-full max-w-5xl bg-white rounded-3xl sm:rounded-[2.5rem] shadow-[0_25px_70px_-15px_rgba(0,80,220,0.18)] border border-slate-100 overflow-hidden flex flex-col md:flex-row relative z-10 transition-all duration-300">
        
        <!-- ============================================================ -->
        <!-- SIDE 1: THE BLUE TECH & FLUID WAVES PANEL WITH MOUSE MOTION -->
        <!-- ============================================================ -->
        <div class="w-full md:w-1/2 relative bg-gradient-to-br from-[#0088FF] via-[#0066FF] to-[#0047CC] p-8 sm:p-10 lg:p-12 text-white flex flex-col justify-between overflow-hidden min-h-[420px] md:min-h-[520px] select-none group"
             x-data="{
                 mx: 0,
                 my: 0,
                 handleMouseMove(e) {
                     const rect = $el.getBoundingClientRect();
                     this.mx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
                     this.my = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
                 }
             }"
             @mousemove="handleMouseMove($event)">
            


            <!-- Fluid Wave 1 (Layer Top-Right) - Reacts to Mouse -->
            <div class="absolute -top-16 -end-16 w-96 h-96 pointer-events-none opacity-40 transition-transform duration-700 ease-out"
                 :style="`transform: translate3d(${mx * -18}px, ${my * -18}px, 0)`">
                <svg viewBox="0 0 400 400" fill="none" class="w-full h-full text-white/30" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 150 Q 150 50 250 120 T 400 80 L 400 0 L 0 0 L 0 200 Z" fill="url(#blueGrad1)" />
                    <defs>
                        <linearGradient id="blueGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#38B6FF" stop-opacity="0.6"/>
                            <stop offset="100%" stop-color="#0066FF" stop-opacity="0.2"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Fluid Wave 2 (Layer Bottom Fluid Curves) - Reacts to Mouse -->
            <div class="absolute -bottom-20 -start-20 w-[120%] h-80 pointer-events-none transition-transform duration-500 ease-out"
                 :style="`transform: translate3d(${mx * 22}px, ${my * 22}px, 0)`">
                <svg viewBox="0 0 800 400" fill="none" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 250 C 200 180, 350 320, 500 240 C 650 160, 750 280, 800 220 L 800 400 L 0 400 Z" fill="#0052CC" fill-opacity="0.4"/>
                    <path d="M0 290 C 180 230, 320 340, 520 270 C 680 200, 720 310, 800 260 L 800 400 L 0 400 Z" fill="#003DA6" fill-opacity="0.6"/>
                </svg>
            </div>

            <!-- Glowing Interactive Circuit Nodes & Diagonal Lines (نفس دوائر وخطوط الصورة المرجعية) -->
            <div class="absolute inset-0 pointer-events-none transition-transform duration-500 ease-out"
                 :style="`transform: translate3d(${mx * 12}px, ${my * 12}px, 0)`">
                
                <!-- Circuit Line 1 with Dot -->
                <svg class="absolute top-12 end-16 w-32 h-32 opacity-40" viewBox="0 0 100 100">
                    <line x1="10" y1="90" x2="80" y2="20" stroke="white" stroke-width="1.5" stroke-dasharray="3 3" />
                    <circle cx="80" cy="20" r="4" fill="white" />
                    <circle cx="80" cy="20" r="8" stroke="white" stroke-width="1" opacity="0.5" />
                </svg>

                <!-- Circuit Line 2 Bottom Left -->
                <svg class="absolute bottom-20 start-12 w-40 h-40 opacity-40" viewBox="0 0 100 100">
                    <line x1="10" y1="80" x2="70" y2="20" stroke="white" stroke-width="1.5" />
                    <circle cx="70" cy="20" r="3.5" fill="white" />
                    <circle cx="10" cy="80" r="5" stroke="white" stroke-width="1" fill="none" />
                </svg>

                <!-- Floating Glowing Orbs -->
                <div class="absolute top-16 start-12 w-6 h-6 rounded-full border-2 border-white/40 bg-white/10 flex items-center justify-center animate-pulse">
                    <div class="w-2 h-2 rounded-full bg-white"></div>
                </div>

                <div class="absolute bottom-28 end-20 w-8 h-8 rounded-full border border-white/30 bg-white/5 flex items-center justify-center">
                    <div class="w-3 h-3 rounded-full border border-white/50"></div>
                </div>
            </div>

            <!-- TOP: Official WorldSkills Algeria Logo (فقط اللوجو كما في الصورة) -->
            <div class="relative z-10 text-start">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 shadow-md group-hover:scale-105 transition-transform duration-300">
                        <img src="/logo.svg" alt="WorldSkills Algeria" class="h-10 sm:h-11 w-auto filter drop-shadow">
                    </div>
                    <div>
                        <span class="font-black text-lg sm:text-xl text-white tracking-tight leading-none block">WorldSkills Algeria</span>
                        <span class="text-[10px] font-bold text-blue-100 uppercase tracking-wider block mt-1">
                            {{ $t('الدورة الوطنية 2026', 'Édition Nationale 2026', 'National Edition 2026') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- CENTER: WELCOME BACK TYPOGRAPHY (متطابق حرفياً مع الصورة المرجعية) -->
            <div class="relative z-10 my-auto py-6 sm:py-8 text-start space-y-3 transition-transform duration-500 ease-out"
                 :style="`transform: translate3d(${mx * 8}px, ${my * 8}px, 0)`">
                
                <p class="text-xs sm:text-sm font-semibold text-blue-100 tracking-wide">
                    {{ $t('يسعدنا لقاؤك مجدداً', 'Ravi de vous revoir', 'Nice to see you again') }}
                </p>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight uppercase leading-tight drop-shadow-sm">
                    {{ $t('أهلاً بعودتك', 'BIENVENUE', 'WELCOME BACK') }}
                </h2>

                <!-- Horizontal White Accent Bar -->
                <div class="w-12 h-1 bg-white rounded-full my-2 shadow-sm"></div>

                <p class="text-xs text-blue-100/85 leading-relaxed max-w-sm font-medium pt-1">
                    {{ __('messages.login_branding_desc') }}
                </p>
            </div>

            <!-- BOTTOM: Subtle Institutional Assurance -->
            <div class="relative z-10 pt-4 border-t border-white/15 text-start">
                <p class="text-[10px] text-blue-100/70 font-semibold">
                    {{ $t('الجمهورية الجزائرية الديمقراطية الشعبية — وزارة التكوين والتعليم المهنيين', 'République Algérienne Démocratique et Populaire', 'People’s Democratic Republic of Algeria') }}
                </p>
            </div>

        </div>

        <!-- ============================================================ -->
        <!-- SIDE 2: PURE WHITE CLEAN FORM (مطابق حرفياً للجانب الأيمن)    -->
        <!-- ============================================================ -->
        <div class="w-full md:w-1/2 p-8 sm:p-10 lg:p-12 flex flex-col justify-center bg-white text-slate-900 relative" x-data="{ showPassword: false }">
            
            @if($mode === 'login')
                {{-- ── 1. REGULAR LOGIN FORM ── --}}
                <div class="text-center space-y-2 mb-8">
                    <h3 class="text-2xl sm:text-3xl font-black text-[#0066FF] tracking-tight">
                        {{ $t('تسجيل الدخول إلى الحساب', 'Connexion au Compte', 'Login Account') }}
                    </h3>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed max-w-xs mx-auto">
                        {{ __('messages.login_subheading') }}
                    </p>
                </div>

                <form wire:submit.prevent="login" class="space-y-5 text-start">
                    
                    <!-- Email or Username (مع الشريط العمودي الأزرق المميز كما في الصورة المرجعية) -->
                    <div class="space-y-1">
                        <div class="relative flex items-center rounded-xl bg-slate-50 border border-slate-200/80 border-s-4 border-s-[#0066FF] focus-within:bg-white focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/15 transition shadow-2xs overflow-hidden group">
                            <input type="text" 
                                   wire:model="loginInput" 
                                   required 
                                   placeholder="{{ $t('البريد الإلكتروني أو اسم المستخدم', 'Email ID ou Nom d’utilisateur', 'Email ID') }}" 
                                   class="w-full px-4 py-3.5 bg-transparent text-xs font-mono font-bold text-[#06205C] placeholder-slate-400 focus:outline-none">
                        </div>
                        @error('loginInput') 
                            <span class="text-[11px] text-rose-600 font-bold block mt-1 ps-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Password with Accent Border & Show/Hide -->
                    <div class="space-y-1">
                        <div class="relative flex items-center rounded-xl bg-slate-50 border border-slate-200/80 border-s-4 border-s-[#0066FF] focus-within:bg-white focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/15 transition shadow-2xs overflow-hidden group">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   wire:model="password" 
                                   required 
                                   placeholder="{{ $t('كلمة المرور', 'Mot de passe', 'Password') }}" 
                                   class="w-full px-4 py-3.5 bg-transparent text-xs font-mono font-bold text-[#06205C] placeholder-slate-400 focus:outline-none pe-12">
                            
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 end-0 pe-3.5 flex items-center text-slate-400 hover:text-brand-500 text-xs font-bold transition">
                                <span x-show="!showPassword">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </span>
                                <span x-show="showPassword" x-cloak class="text-brand-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </span>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-[11px] text-rose-600 font-bold block mt-1 ps-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Row: Keep me signed in & Forgot Password (مطابق تماماً للصورة) -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600 hover:text-slate-900 transition">
                            <input type="checkbox" wire:model="remember" class="w-4 h-4 rounded border-slate-300 text-[#0066FF] focus:ring-[#0066FF]">
                            <span class="text-xs font-semibold">
                                {{ $t('تذكرني على هذا الجهاز', 'Garder ma session active', 'Keep me signed in') }}
                            </span>
                        </label>

                        <button type="button" wire:click="toggleForgotMode" class="text-xs font-bold text-slate-500 hover:text-[#0066FF] transition">
                            {{ $t('نسيت كلمة المرور؟', 'Mot de passe oublié ?', 'Forgot Password?') }}
                        </button>
                    </div>

                    <!-- Submit Button: Pill Button like SUBSCRIBE / LOGIN in the Image -->
                    <div class="pt-4">
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="w-full py-3.5 rounded-full bg-gradient-to-r from-[#0077FF] via-[#0066FF] to-[#0052CC] hover:from-[#0052CC] hover:to-[#003EA3] text-white font-black text-sm uppercase tracking-wider shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 active:scale-[0.98] cursor-pointer disabled:opacity-75">
                            
                            <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                                <span>{{ $t('تسجيل الدخول', 'SE CONNECTER', 'SIGN IN') }}</span>
                            </span>

                            <span wire:loading wire:target="login" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span>{{ $t('جاري التوثيق...', 'Connexion...', 'Signing in...') }}</span>
                            </span>
                        </button>
                    </div>

                </form>

            @else
                {{-- ── 2. FORGOT PASSWORD / ACCOUNT RECOVERY FORM ── --}}
                <div class="text-start space-y-4">
                    <button type="button" wire:click="toggleForgotMode" class="text-xs font-black text-slate-500 hover:text-[#0066FF] transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 rtl:rotate-180 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>{{ $t('العودة إلى تسجيل الدخول', 'Retour à la connexion', 'Back to Sign In') }}</span>
                    </button>

                    <div class="space-y-1">
                        <h3 class="text-2xl font-black text-[#0066FF]">
                            {{ $t('استرجاع الحساب', 'Récupération', 'Account Recovery') }}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            {{ $t('أدخل رقم التعريف الوطني (NIN) أو جواز السفر المسجل للتحقق من ملكية الحساب.', 'Entrez votre numéro NIN ou passeport enregistré pour vérifier votre compte.', 'Enter your registered NIN or Passport to verify ownership.') }}
                        </p>
                    </div>

                    @if($recoveryStep === 1)
                        <form wire:submit.prevent="verifyIdentity" class="space-y-4">
                            <div class="space-y-1">
                                <div class="relative flex items-center rounded-xl bg-slate-50 border border-slate-200/80 border-s-4 border-s-[#0066FF] focus-within:bg-white focus-within:border-brand-500 transition shadow-2xs overflow-hidden">
                                    <input type="text" 
                                           wire:model="identityInput" 
                                           required 
                                           placeholder="{{ $t('رقم التعريف الوطني NIN أو رقم الجواز', 'NIN ou Passeport', 'NIN or Passport') }}" 
                                           class="w-full px-4 py-3.5 bg-transparent text-xs font-mono font-bold text-[#06205C] placeholder-slate-400 focus:outline-none">
                                </div>
                                @error('identityInput') 
                                    <span class="text-[11px] text-rose-600 font-bold block mt-1 ps-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="w-full py-3.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2 cursor-pointer">
                                <span>{{ $t('التحقق من الهوية', 'Vérifier l’Identité', 'Verify Identity') }}</span>
                            </button>
                        </form>
                    @else
                        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold">
                            <div class="font-black text-emerald-800">{{ $t('تم التحقق بنجاح!', 'Vérifié avec succès !', 'Verified successfully!') }}</div>
                            <div class="text-[11px] text-slate-600 mt-0.5">{{ $verifiedUserName }} ({{ $verifiedUserEmail }})</div>
                        </div>

                        <form wire:submit.prevent="resetPassword" class="space-y-3.5">
                            <div class="space-y-1">
                                <div class="relative flex items-center rounded-xl bg-slate-50 border border-slate-200/80 border-s-4 border-s-[#0066FF] focus-within:bg-white transition shadow-2xs overflow-hidden">
                                    <input type="password" wire:model="newPassword" required placeholder="{{ $t('كلمة المرور الجديدة', 'Nouveau Mot de Passe', 'New Password') }}" class="w-full px-4 py-3 bg-transparent text-xs font-mono font-bold text-[#06205C] focus:outline-none">
                                </div>
                                @error('newPassword') <span class="text-xs text-rose-600 font-bold block mt-0.5">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <div class="relative flex items-center rounded-xl bg-slate-50 border border-slate-200/80 border-s-4 border-s-[#0066FF] focus-within:bg-white transition shadow-2xs overflow-hidden">
                                    <input type="password" wire:model="newPasswordConfirmation" required placeholder="{{ $t('تأكيد كلمة المرور الجديدة', 'Confirmer le Mot de Passe', 'Confirm Password') }}" class="w-full px-4 py-3 bg-transparent text-xs font-mono font-bold text-[#06205C] focus:outline-none">
                                </div>
                                @error('newPasswordConfirmation') <span class="text-xs text-rose-600 font-bold block mt-0.5">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-full bg-[#0066FF] hover:bg-[#0052CC] text-white font-black text-xs uppercase tracking-wider shadow-lg transition">
                                <span>{{ $t('تحديث كلمة المرور والدخول', 'Mettre à jour & Se connecter', 'Update & Sign In') }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            @endif

        </div>

    </div>
</div>
