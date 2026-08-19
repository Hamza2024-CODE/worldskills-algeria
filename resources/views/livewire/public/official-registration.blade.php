@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="min-h-screen bg-gradient-to-b from-slate-50 via-blue-50/20 to-slate-100 py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-3xl mx-auto space-y-8">

        <!-- Header Bar with Language Switcher & Branding -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white/80 backdrop-blur-md p-4 rounded-3xl border border-slate-200/80 shadow-xs">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/logo.svg" alt="WorldSkills Algeria" class="h-11 w-auto">
                <div class="flex flex-col text-start">
                    <span class="font-black text-base text-[#06205C] leading-none">WorldSkills Algeria</span>
                    <span class="text-[9px] font-black text-brand-500 uppercase tracking-widest mt-0.5">ACCREDITATION PORTAL 2026</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" class="px-2.5 py-1 rounded-lg text-xs font-black {{ $locale === 'ar' ? 'bg-[#06205C] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">عربي</a>
                <a href="{{ route('lang.switch', ['locale' => 'fr']) }}" class="px-2.5 py-1 rounded-lg text-xs font-black {{ $locale === 'fr' ? 'bg-[#06205C] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">FR</a>
                <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="px-2.5 py-1 rounded-lg text-xs font-black {{ $locale === 'en' ? 'bg-[#06205C] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">EN</a>
            </div>
        </div>

        <!-- Title Banner -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl sm:text-3xl font-black text-[#06205C] tracking-tight">
                {{ $t('بوابة الاعتماد والتسجيل الرسمي للحكام والوفود والصحافة', 'Portail d’Accréditation et d’Inscription Officielle', 'Official Accreditation & Registration Portal') }}
            </h1>
            <p class="text-xs text-slate-500 font-bold max-w-xl mx-auto">
                {{ $t('نظام تسجيل وتوثيق صفة المحكمين والخبراء ومسؤولي الوفود والإعلاميين مع الحفظ الأمني التلقائي', 'Système d’inscription officiel pour Juges, Chefs de Délégation et Presse.', 'Official registration system for Jury Experts, Delegation Heads, and Press.') }}
            </p>
        </div>

        @if(!$isOpen || !$accreditationRegistrationEnabled)
            <!-- Locked / Closed Registration Banner -->
            <div class="bg-white rounded-3xl p-8 border-2 border-rose-200 shadow-xl text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-xl font-black text-slate-900">
                    {{ $t('التسجيل الرسمي مغلق حالياً', 'Inscription Officielle Fermée', 'Official Registration Currently Closed') }}
                </h2>
                <p class="text-xs text-slate-600 font-medium leading-relaxed max-w-md mx-auto">
                    {{ $t('تم توقيف وإغلاق التسجيل الرسمي للوفود والحكام والصحافة من طرف الإدارة العليا لأولمبياد WorldSkills Algeria 2026.', 'L’inscription officielle est suspendue par l’administration centrale.', 'Official registration has been closed by the WorldSkills Algeria 2026 Executive Committee.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-xl bg-[#06205C] text-white text-xs font-black hover:bg-blue-900 transition inline-block">
                        {{ $t('العودة للصفحة الرئيسية', 'Retour à l’Accueil', 'Back to Home') }}
                    </a>
                </div>
            </div>
        @elseif($submitted)
            <!-- Success Screen -->
            <div class="bg-white rounded-3xl p-8 border-2 border-emerald-200 shadow-xl text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-2xl font-black text-slate-900">
                    {{ $t('تم تسجيل طلبكم بنجاح!', 'Demande Enregistrée avec Succès !', 'Registration Submitted Successfully!') }}
                </h2>
                <p class="text-xs text-slate-600 font-medium leading-relaxed max-w-md mx-auto">
                    {{ $t('طلب الاعتماد الخاص بكم قيد التفعيل والمراجعة الفورية من طرف أمانة اللجنة الوطنية والمشرفين.', 'Votre demande est en cours de validation par le comité d’organisation.', 'Your accreditation request is pending review and activation by the competition committee.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-black hover:bg-emerald-700 transition inline-block shadow-md">
                        {{ $t('تسجيل الدخول للمنصة', 'Se Connecter', 'Log In to Platform') }}
                    </a>
                </div>
            </div>
        @else
            <!-- Registration Form Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl space-y-6">

                @if(session('error'))
                    <div class="p-3.5 bg-rose-50 text-rose-700 text-xs font-bold rounded-xl border border-rose-200">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                <!-- Instant Document OCR Match Verification Badge -->
                @if($instant_verified)
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-center gap-3 text-emerald-950 text-xs font-bold shadow-xs animate-fade-slide-in">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <div class="font-black text-emerald-950 text-xs">
                                {{ $t('تم الفحص والتوثيق الآني بنجاح', 'Vérification en temps réel réussie', 'Instant Document Matching Verified') }}
                            </div>
                            <div class="text-[11px] text-emerald-700 font-bold mt-0.5 leading-snug">
                                {{ $verification_message }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Official Role Selection Tabs (SVG Icons) -->
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-2.5">
                        {{ $t('اختر الصفة الرسمية المعتمدة *', 'Sélectionnez votre rôle officiel *', 'Select Your Official Role *') }}
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Judge Button -->
                        <button type="button" wire:click="$set('role', 'JUDGE')"
                            class="p-4 rounded-2xl border-2 text-center transition flex flex-col items-center justify-center gap-2 {{ $role === 'JUDGE' ? 'border-indigo-600 bg-indigo-50/70 text-indigo-950 font-black shadow-xs ring-1 ring-indigo-500' : 'border-slate-200 bg-slate-50/60 text-slate-600 font-bold hover:bg-slate-100' }}">
                            <div class="w-10 h-10 rounded-xl {{ $role === 'JUDGE' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.97zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.97z"/></svg>
                            </div>
                            <span class="text-xs font-black">{{ $t('حكم / خبير تقييم', 'Juge / Expert', 'Jury Expert / Judge') }}</span>
                        </button>

                        <!-- Delegation Button -->
                        <button type="button" wire:click="$set('role', 'COUNTRY_ADMIN')"
                            class="p-4 rounded-2xl border-2 text-center transition flex flex-col items-center justify-center gap-2 {{ $role === 'COUNTRY_ADMIN' ? 'border-blue-600 bg-blue-50/70 text-blue-950 font-black shadow-xs ring-1 ring-blue-500' : 'border-slate-200 bg-slate-50/60 text-slate-600 font-bold hover:bg-slate-100' }}">
                            <div class="w-10 h-10 rounded-xl {{ $role === 'COUNTRY_ADMIN' ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V8.5M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                            </div>
                            <span class="text-xs font-black">{{ $t('مسؤول وفد وطني / دولي', 'Chef de Délégation', 'Delegation Head') }}</span>
                        </button>

                        <!-- Media Button -->
                        <button type="button" wire:click="$set('role', 'MEDIA_MANAGER')"
                            class="p-4 rounded-2xl border-2 text-center transition flex flex-col items-center justify-center gap-2 {{ $role === 'MEDIA_MANAGER' ? 'border-amber-600 bg-amber-50/70 text-amber-950 font-black shadow-xs ring-1 ring-amber-500' : 'border-slate-200 bg-slate-50/60 text-slate-600 font-bold hover:bg-slate-100' }}">
                            <div class="w-10 h-10 rounded-xl {{ $role === 'MEDIA_MANAGER' ? 'bg-amber-600 text-white' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                            </div>
                            <span class="text-xs font-black">{{ $t('صحافة وإعلام معتمد', 'Presse & Média', 'Media & Press') }}</span>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="registerOfficial" class="space-y-4 text-xs font-semibold">

                    <!-- Profile Photo Section: Upload File OR Live Camera Capture -->
                    <div x-data="{
                        mode: 'upload',
                        cameraOpen: false,
                        facingMode: 'user',
                        async getMediaStream(mode) {
                            const getUM = (c) => {
                                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                    return navigator.mediaDevices.getUserMedia(c);
                                }
                                const legacyFn = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.getUserMedia;
                                if (legacyFn) {
                                    return new Promise((res, rej) => legacyFn.call(navigator, c, res, rej));
                                }
                                return Promise.reject(new Error('Camera API Not Supported'));
                            };
                            try {
                                return await getUM({ video: { facingMode: mode } });
                            } catch(e1) {
                                try {
                                    return await getUM({ video: { facingMode: { exact: mode } } });
                                } catch(e2) {
                                    return await getUM({ video: true });
                                }
                            }
                        },
                        async startCamera() {
                            this.mode = 'camera';
                            try {
                                const s = await this.getMediaStream(this.facingMode);
                                this.stream = s;
                                this.cameraOpen = true;
                                setTimeout(async () => {
                                    const videoEl = $refs.video;
                                    if (videoEl) {
                                        videoEl.setAttribute('playsinline', 'true');
                                        videoEl.setAttribute('webkit-playsinline', 'true');
                                        videoEl.setAttribute('muted', 'true');
                                        videoEl.muted = true;
                                        videoEl.srcObject = s;
                                        try { await videoEl.play(); } catch(pe) { console.log('iOS play fallback:', pe); }
                                    }
                                }, 100);
                            } catch(err) {
                                alert('{{ __('messages.camera_access_error') }}: ' + (err.message || err));
                                this.mode = 'upload';
                            }
                        },
                        async toggleCamera() {
                            this.facingMode = this.facingMode === 'user' ? 'environment' : 'user';
                            if (this.stream) { this.stream.getTracks().forEach(t => t.stop()); }
                            await this.startCamera();
                        },
                        stopCamera() {
                            if (this.stream) { this.stream.getTracks().forEach(t => t.stop()); }
                            this.cameraOpen = false;
                        },
                        capture() {
                            const canvas = document.createElement('canvas');
                            canvas.width = $refs.video.videoWidth || 640;
                            canvas.height = $refs.video.videoHeight || 480;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage($refs.video, 0, 0, canvas.width, canvas.height);
                            const dataUrl = canvas.toDataURL('image/jpeg');
                            $wire.setCapturedPhoto(dataUrl);
                            this.stopCamera();
                            this.mode = 'captured';
                        }
                    }" class="p-5 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black text-slate-800">
                                {{ $t('الصورة الشخصية الرسمية (رفع صورة أو التقاط مباشر بالكاميرا) *', 'Photo d’identité (Téléverser ou Capture Caméra) *', 'Official Photo (Upload File or Live Camera) *') }}
                            </label>

                            <div class="flex items-center gap-1.5 bg-slate-200/70 p-1 rounded-xl">
                                <button type="button" @click="mode = 'upload'; stopCamera();" class="px-3 py-1 rounded-lg text-[11px] font-black transition" :class="mode === 'upload' ? 'bg-white text-indigo-900 shadow-xs' : 'text-slate-600'">
                                    📁 {{ $t('رفع صورة', 'Fichier', 'Upload') }}
                                </button>
                                <button type="button" @click="startCamera()" class="px-3 py-1 rounded-lg text-[11px] font-black transition" :class="mode === 'camera' || mode === 'captured' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600'">
                                    📷 {{ $t('التقاط مباشر بالكاميرا', 'Caméra', 'Live Capture') }}
                                </button>
                            </div>
                        </div>

                        <!-- Live Camera Video Window -->
                        <div x-show="mode === 'camera'" class="flex flex-col items-center gap-3 pt-2">
                            <div class="relative w-full max-w-sm rounded-2xl overflow-hidden border-2 border-indigo-600 shadow-lg bg-black aspect-video flex items-center justify-center">
                                <video x-ref="video" autoplay playsinline webkit-playsinline muted class="w-full h-full object-cover"></video>
                                <div class="absolute inset-0 border-2 border-dashed border-white/50 rounded-2xl pointer-events-none"></div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="toggleCamera()" class="px-3.5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs transition flex items-center gap-1.5" title="Switch Camera">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span>{{ $t('تبديل الكاميرا', 'Changer caméra', 'Switch Camera') }}</span>
                                </button>
                                <button type="button" @click="capture()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $t('التقاط الصورة الآن', 'Prendre la photo', 'Capture Photo Now') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Upload File Input / Preview -->
                        <div x-show="mode !== 'camera'" class="flex flex-col sm:flex-row items-center gap-4 pt-1">
                            <div class="shrink-0">
                                @if($captured_photo_data)
                                    <img src="{{ $captured_photo_data }}" alt="Captured Photo" class="w-20 h-20 rounded-2xl object-cover border-2 border-indigo-600 shadow-md">
                                @elseif($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="w-20 h-20 rounded-2xl object-cover border-2 border-slate-200 shadow-sm">
                                @else
                                    <div class="w-20 h-20 rounded-2xl bg-slate-200 text-slate-500 flex flex-col items-center justify-center border-2 border-dashed border-slate-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span class="text-[9px] font-bold mt-1">{{ $t('صورة رسمية', 'Photo officielle', 'Official Photo') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 text-center sm:text-start space-y-1">
                                <p class="text-[10px] text-slate-500 font-medium">
                                    {{ $t('صورة واضحة بخلفية بيضاء للاعتماد والطباعة الفورية على الشارة', 'Photo claire fond blanc pour accréditation', 'Clear photo with white background for official badge printing') }}
                                </p>

                                @if($captured_photo_data)
                                    <div class="text-xs font-extrabold text-emerald-700 flex items-center gap-1.5">
                                        ✓ {{ $t('تم التقاط الصورة بنجاح بواسطة الكاميرا المباشرة', 'Photo capturée par caméra', 'Photo captured cleanly via Live Camera') }}
                                    </div>
                                @else
                                    <input type="file" wire:model="photo" class="text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                                @endif

                                @error('photo') <span class="block text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">
                                {{ $t('الاسم واللقب الكامل *', 'Nom et Prénom *', 'Full Name *') }}
                            </label>
                            <input wire:model.blur="name" type="text" placeholder="{{ $t('مثال: الخبير أحمد القادري', 'Ex: Ahmed Elkadri', 'Ex: Dr. Ahmed Kadri') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            @error('name') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-slate-700 font-bold mb-1">
                                {{ $isAlgeria ? $t('رقم بطاقة التعريف الوطنية (NIN 18 رقم بالضبط) *', 'N° d’Identification Nationale (18 chiffres max) *', 'National ID Number (18 digits max) *') : $t('رقم بطاقة الهوية / رقم الجواز *', 'N° Passeport / Carte d’Identité *', 'Passport / National ID Number *') }}
                            </label>
                            <input wire:model.live.debounce.150ms="national_id"
                                   type="text"
                                   @if($isAlgeria) maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18);" @endif
                                   placeholder="{{ $isAlgeria ? '109283746501928374 (18 رقم)' : 'A92837465' }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-mono font-bold">
                            @error('national_id') <span class="block text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">
                                {{ $t('البريد الإلكتروني الرسمي *', 'Adresse Email Officielle *', 'Official Email Address *') }}
                            </label>
                            <input wire:model.blur="email" type="email" placeholder="official@worldskills.dz" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            @error('email') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-slate-700 font-bold mb-1">
                                {{ $t('رقم الهاتف / الواتساب الرسمي *', 'N° Téléphone / WhatsApp *', 'Phone / WhatsApp Number *') }}
                            </label>
                            <input wire:model.blur="phone" type="text" required placeholder="{{ $this->phonePlaceholder }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            @error('phone') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Role Dependent Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">
                                {{ $t('دولة الوفد / البلد الأصلي *', 'Pays / Délégation Nationale *', 'Country / Delegation *') }}
                            </label>
                            <select wire:model.live="country_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}">{{ app()->getLocale() === 'fr' ? $c->name_fr : (app()->getLocale() === 'en' ? $c->name_en : $c->name_ar) }} ({{ $c->code }})</option>
                                @endforeach
                            </select>
                            @error('country_id') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        @if($role === 'JUDGE')
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">
                                    {{ $t('التخصص المهني المراد التحكيم فيه *', 'Métier / Compétence d’Arbitrage *', 'Assigned Trade Skill *') }}
                                </label>
                                <select wire:model="skill_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-indigo-900 border-indigo-200">
                                    @foreach($skills as $s)
                                        <option value="{{ $s->id }}">{{ $s->getLocalized('name') }} ({{ $s->code }})</option>
                                    @endforeach
                                </select>
                                @error('skill_id') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        @if($role === 'MEDIA_MANAGER')
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">
                                    {{ $t('اسم المؤسسة الإعلامية / الجريدة / القناة *', 'Organisme de Presse / Média *', 'Media / Press Organization *') }}
                                </label>
                                <input wire:model="organization_name" type="text" placeholder="{{ $t('التلفزيون الجزائري / جريدة رسمية', 'Télévision Algérienne / Presse', 'National TV / Press Journal') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                                @error('organization_name') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Media Press Document Upload (بطاقة الصحافة / بطاقة الهوية / الجواز) -->
                    @if($role === 'MEDIA_MANAGER')
                        <div x-data="{
                            mode: 'upload',
                            cameraOpen: false,
                            stream: null,
                            startCamera() {
                                this.mode = 'camera';
                                navigator.mediaDevices.getUserMedia({ video: { width: 1280, height: 720 } }).then(s => {
                                    this.stream = s;
                                    $refs.docVideo.srcObject = s;
                                    this.cameraOpen = true;
                                }).catch(err => {
                                    alert('{{ __('messages.camera_access_error') }}');
                                    this.mode = 'upload';
                                });
                            },
                            stopCamera() {
                                if (this.stream) { this.stream.getTracks().forEach(t => t.stop()); }
                                this.cameraOpen = false;
                            },
                            capture() {
                                const canvas = document.createElement('canvas');
                                canvas.width = $refs.docVideo.videoWidth || 1280;
                                canvas.height = $refs.docVideo.videoHeight || 720;
                                const ctx = canvas.getContext('2d');
                                ctx.drawImage($refs.docVideo, 0, 0, canvas.width, canvas.height);
                                const dataUrl = canvas.toDataURL('image/jpeg');
                                $wire.setCapturedIdCard(dataUrl);
                                this.stopCamera();
                                this.mode = 'captured';
                            }
                        }" class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200/90 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-black text-amber-950">
                                    {{ $t('رفع أو تصوير بطاقة الصحافة المهنية / بطاقة الهوية (PDF / صورة) *', 'Carte de Presse Professionnelle ou Pièce d’Identité *', 'Professional Press Card or ID Document (File or Camera) *') }}
                                </label>
                                <div class="flex items-center gap-1 bg-amber-200/60 p-1 rounded-xl">
                                    <button type="button" @click="mode = 'upload'; stopCamera();" class="px-2.5 py-1 rounded-lg text-[10px] font-black transition" :class="mode === 'upload' ? 'bg-white text-amber-950 shadow-xs' : 'text-amber-800'">
                                        📁 {{ $t('ملف', 'Fichier', 'File') }}
                                    </button>
                                    <button type="button" @click="startCamera()" class="px-2.5 py-1 rounded-lg text-[10px] font-black transition" :class="mode === 'camera' || mode === 'captured' ? 'bg-amber-600 text-white shadow-xs' : 'text-amber-800'">
                                        📷 {{ $t('تصوير مباشر', 'Caméra', 'Camera') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Document Live Camera Stream -->
                            <div x-show="mode === 'camera'" class="flex flex-col items-center gap-3 pt-2">
                                <div class="relative w-full max-w-md rounded-2xl overflow-hidden border-2 border-amber-500 shadow-lg bg-black aspect-video flex items-center justify-center">
                                    <video x-ref="docVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                                    <div class="absolute inset-4 border-2 border-dashed border-amber-300 rounded-xl pointer-events-none flex items-center justify-center text-white/70 text-xs font-bold">
                                        {{ $t('ضع بطاقة الصحافة داخل الإطار', 'Placez la carte de presse dans le cadre', 'Place press card inside frame') }}
                                    </div>
                                </div>
                                <button type="button" @click="capture()" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                                    <span>📸 {{ $t('التقاط بطاقة الصحافة الآن', 'Capturer la carte', 'Capture Press Badge') }}</span>
                                </button>
                            </div>

                            <div x-show="mode !== 'camera'">
                                @if($captured_id_card_data)
                                    <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-amber-300">
                                        <img src="{{ $captured_id_card_data }}" class="w-24 h-16 rounded-lg object-cover border border-amber-400">
                                        <div class="text-xs font-bold text-amber-900">
                                            ✓ {{ $t('تم تصوير بطاقة الصحافة بنجاح عبر الكاميرا المباشرة', 'Carte de presse capturée', 'Press badge captured via camera') }}
                                        </div>
                                    </div>
                                @else
                                    <input type="file" wire:model="press_card_file" class="text-xs text-slate-700 file:mr-4 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-amber-600 file:text-white hover:file:bg-amber-700 cursor-pointer">
                                @endif
                            </div>
                            @error('press_card_file') <span class="block text-rose-600 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <!-- Official Document Upload for Judges and Delegation Admins -->
                        <div x-data="{
                            mode: 'upload',
                            cameraOpen: false,
                            stream: null,
                            startCamera() {
                                this.mode = 'camera';
                                navigator.mediaDevices.getUserMedia({ video: { width: 1280, height: 720 } }).then(s => {
                                    this.stream = s;
                                    $refs.docVideo.srcObject = s;
                                    this.cameraOpen = true;
                                }).catch(err => {
                                    alert('{{ __('messages.camera_access_error') }}');
                                    this.mode = 'upload';
                                });
                            },
                            stopCamera() {
                                if (this.stream) { this.stream.getTracks().forEach(t => t.stop()); }
                                this.cameraOpen = false;
                            },
                            capture() {
                                const canvas = document.createElement('canvas');
                                canvas.width = $refs.docVideo.videoWidth || 1280;
                                canvas.height = $refs.docVideo.videoHeight || 720;
                                const ctx = canvas.getContext('2d');
                                ctx.drawImage($refs.docVideo, 0, 0, canvas.width, canvas.height);
                                const dataUrl = canvas.toDataURL('image/jpeg');
                                $wire.setCapturedIdCard(dataUrl);
                                this.stopCamera();
                                this.mode = 'captured';
                            }
                        }" class="p-4 rounded-2xl bg-blue-50/80 border border-blue-200/90 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-black text-blue-950">
                                    {{ $isAlgeria
                                        ? $t('رفع أو تصوير بطاقة التعريف الوطنية (NIN) / جواز السفر *', 'Carte d’Identité Nationale (NIN) ou Passeport *', 'National ID Card (NIN) or Passport (File or Camera) *')
                                        : $t('رفع أو تصوير جواز السفر الدولي المعتمد *', 'Passeport International Scanné *', 'Scanned International Passport (File or Camera) *')
                                    }}
                                </label>
                                <div class="flex items-center gap-1 bg-blue-200/60 p-1 rounded-xl">
                                    <button type="button" @click="mode = 'upload'; stopCamera();" class="px-2.5 py-1 rounded-lg text-[10px] font-black transition" :class="mode === 'upload' ? 'bg-white text-blue-950 shadow-xs' : 'text-blue-800'">
                                        📁 {{ $t('ملف', 'Fichier', 'File') }}
                                    </button>
                                    <button type="button" @click="startCamera()" class="px-2.5 py-1 rounded-lg text-[10px] font-black transition" :class="mode === 'camera' || mode === 'captured' ? 'bg-blue-600 text-white shadow-xs' : 'text-blue-800'">
                                        📷 {{ $t('تصوير مباشر', 'Caméra', 'Camera') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Live Video Window for Document Scan -->
                            <div x-show="mode === 'camera'" class="flex flex-col items-center gap-3 pt-2">
                                <div class="relative w-full max-w-md rounded-2xl overflow-hidden border-2 border-blue-600 shadow-lg bg-black aspect-video flex items-center justify-center">
                                    <video x-ref="docVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                                    <div class="absolute inset-4 border-2 border-dashed border-white/60 rounded-xl pointer-events-none flex items-center justify-center text-white/80 text-xs font-bold">
                                        {{ $t('ضع بطاقة التعريف أو جواز السفر داخل الإطار', 'Placez la carte d\'identité ou passeport dans le cadre', 'Place ID card or passport inside frame') }}
                                    </div>
                                </div>
                                <button type="button" @click="capture()" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                                    <span>📸 {{ $t('التقاط صورة الوثيقة الآن', 'Capturer le document', 'Capture ID / Passport Document') }}</span>
                                </button>
                            </div>iv>

                            <!-- Live Video Window for Document Scan -->
                            <div x-show="mode === 'camera'" class="flex flex-col items-center gap-3 pt-2">
                                <div class="relative w-full max-w-md rounded-2xl overflow-hidden border-2 border-blue-600 shadow-lg bg-black aspect-video flex items-center justify-center">
                                    <video x-ref="docVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                                    <div class="absolute inset-4 border-2 border-dashed border-white/60 rounded-xl pointer-events-none flex items-center justify-center text-white/80 text-xs font-bold">
                                        ضع بطاقة التعريف أو جواز السفر داخل الإطار
                                    </div>
                                </div>
                                <button type="button" @click="capture()" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                                    <span>📸 {{ $t('التقاط صورة الوثيقة الآن', 'Capturer le document', 'Capture ID / Passport Document') }}</span>
                                </button>
                            </div>

                            <div x-show="mode !== 'camera'">
                                @if($captured_id_card_data)
                                    <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-blue-300">
                                        <img src="{{ $captured_id_card_data }}" class="w-24 h-16 rounded-lg object-cover border border-blue-400">
                                        <div class="text-xs font-bold text-blue-900">
                                            ✓ {{ $t('تم تصوير الوثيقة بنجاح بواسطة الكاميرا المباشرة', 'Document identité capturé', 'ID document captured cleanly via Live Camera') }}
                                        </div>
                                    </div>
                                @else
                                    <input type="file" wire:model="id_card_file" class="text-xs text-slate-700 file:mr-4 file:py-1.5 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                                @endif
                            </div>
                            @error('id_card_file') <span class="block text-rose-600 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <!-- Password Fields (Required ONLY for JUDGE & COUNTRY_ADMIN) -->
                    @if($role !== 'MEDIA_MANAGER')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">
                                    {{ $t('كلمة السر للحساب *', 'Mot de passe *', 'Account Password *') }}
                                </label>
                                <input wire:model="password" type="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                                @error('password') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">
                                    {{ $t('تأكيد كلمة السر *', 'Confirmer le mot de passe *', 'Confirm Password *') }}
                                </label>
                                <input wire:model="password_confirmation" type="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#06205C] hover:bg-blue-900 text-white font-black text-xs sm:text-sm shadow-xl shadow-blue-950/20 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $t('تقديم طلب الاعتماد والتسجيل الرسمي', 'Soumettre la Demande d’Accréditation', 'Submit Official Accreditation Request') }}</span>
                        </button>
                    </div>
                </form>

            </div>
        @endif

    </div>
</div>
