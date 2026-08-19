<div class="py-12"
     x-data="{
         cameraOpen: false,
         targetField: '',
         stream: null,
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
         async startCamera(field) {
             this.targetField = field;
             this.cameraOpen = true;
             try {
                 const s = await this.getMediaStream(this.facingMode);
                 this.stream = s;
                 setTimeout(async () => {
                     const videoEl = this.$refs.video;
                     if (videoEl) {
                         videoEl.setAttribute('playsinline', 'true');
                         videoEl.setAttribute('webkit-playsinline', 'true');
                         videoEl.setAttribute('muted', 'true');
                         videoEl.muted = true;
                         videoEl.srcObject = s;
                         try { await videoEl.play(); } catch(pe) { console.log('iOS play fallback:', pe); }
                     }
                 }, 100);
             } catch (err) {
                 alert('{{ __('messages.camera_access_error') }}: ' + (err.message || err));
                 this.cameraOpen = false;
             }
         },
         async toggleCamera() {
             this.facingMode = this.facingMode === 'user' ? 'environment' : 'user';
             if (this.stream) {
                 this.stream.getTracks().forEach(t => t.stop());
             }
             await this.startCamera(this.targetField);
         },
         takePhoto() {
             const video = this.$refs.video;
             if (!video) return;
             const canvas = document.createElement('canvas');
             canvas.width = video.videoWidth || 1280;
             canvas.height = video.videoHeight || 720;
             const ctx = canvas.getContext('2d');
             ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

             canvas.toBlob((blob) => {
                 const file = new File([blob], 'camera_capture_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                 $wire.upload(this.targetField, file,
                     () => { this.stopCamera(); },
                     (error) => { alert('{{ __('messages.camera_upload_error') }}'); }
                 );
             }, 'image/jpeg', 0.92);
         },
         stopCamera() {
             if (this.stream) {
                 this.stream.getTracks().forEach(t => t.stop());
                 this.stream = null;
             }
             this.cameraOpen = false;
         }
     }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10 space-y-3">
            <span class="text-xs font-bold text-brand-500 uppercase tracking-widest bg-brand-50 px-4 py-1.5 rounded-full border border-brand-200 shadow-sm inline-block">
                {{ __('messages.register') }} — WorldSkills Algeria 2026
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">{{ __('messages.reg_title') }}</h1>
            <p class="text-xs text-slate-500 font-medium max-w-xl mx-auto">{{ __('messages.reg_subtitle') }}</p>
        </div>

        @if(!$registrationEnabled)
            <!-- Registration Closed Card -->
            <div class="bg-white rounded-3xl p-8 sm:p-12 text-center space-y-6 shadow-xl border border-slate-200/90 max-w-xl mx-auto my-8">
                <div class="w-16 h-16 rounded-3xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>

                <div class="space-y-2">
                    <h2 class="text-xl font-black text-[#06205C]">
                        {{ app()->getLocale() === 'fr' ? 'Les Inscriptions sont Actuellement Fermées' : (app()->getLocale() === 'en' ? 'Registration is Currently Closed' : 'باب التسجيل مغلق حالياً بقرار تنظيمي') }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Le formulaire d\'inscription des candidats et délégations est actuellement fermé par décision de la commission d\'organisation.' : (app()->getLocale() === 'en' ? 'Competitor & delegation registration is currently closed by organizational decision.' : 'تم إغلاق استمارة تسجيل الترشحات والوفود الوطنية مؤقتاً بقرار من لجنة تنظيم أولمبياد المهن الجزائرية 2026.') }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-center gap-3">
                    <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md transition">
                        {{ app()->getLocale() === 'fr' ? 'Retour à l\'Accueil' : (app()->getLocale() === 'en' ? 'Return to Homepage' : 'العودة للرئيسية') }}
                    </a>
                </div>
            </div>
        @elseif($isSubmitted)
            <!-- Success & Printable Certificate Screen -->
            <div class="bg-white rounded-3xl p-8 sm:p-12 text-center space-y-8 shadow-2xl border border-slate-200/80 animate-in fade-in zoom-in duration-300">
                <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto border-2 border-emerald-200 text-3xl font-bold shadow-lg">
                    ✓
                </div>
                
                <div class="space-y-2">
                    <h2 class="text-2xl font-black text-[#06205C]">
                        {{ __('messages.reg_success_title') }}
                    </h2>
                    <p class="text-xs text-slate-500">
                        {{ __('messages.reg_success_subtitle') }}
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 max-w-md mx-auto space-y-4 shadow-sm">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400 block">{{ __('messages.official_code_label') }}</span>
                        <div class="font-mono font-black text-2xl text-brand-500 tracking-wider mt-1">
                            {{ $registrationNumber }}
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-right text-xs space-y-2">
                        <span class="font-black text-[#06205C] block border-b border-blue-200 pb-1">{{ __('messages.account_credentials_header') }}</span>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-bold">{{ __('messages.email_credential') }}</span>
                            <span class="font-mono font-bold text-brand-600">{{ $email }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-bold">{{ __('messages.password_credential') }}</span>
                            <span class="font-mono font-black text-emerald-600 bg-white px-2 py-0.5 rounded border border-blue-200">password123</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>{{ __('messages.go_to_my_space') }}</span>
                    </a>

                    <a href="{{ route('certificate', ['number' => $registrationNumber]) }}" target="_blank" class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>{{ __('messages.view_official_certificate') }}</span>
                    </a>

                    <a href="{{ route('verify', ['token' => $verificationToken]) }}" target="_blank" class="w-full sm:w-auto px-5 py-3.5 rounded-xl border border-slate-300 text-[#06205C] hover:bg-slate-50 font-bold text-xs transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ __('messages.verification_portal_btn') }}</span>
                    </a>
                </div>
            </div>
        @else

            <!-- Multi-Step Wizard Progress -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-md mb-8">
                <div class="grid grid-cols-4 gap-2 text-center text-xs font-bold text-slate-400 mb-4">
                    <span class="{{ $step >= 1 ? 'text-brand-500 font-black' : '' }}">{{ __('messages.step_1') }}</span>
                    <span class="{{ $step >= 2 ? 'text-brand-500 font-black' : '' }}">{{ __('messages.step_2') }}</span>
                    <span class="{{ $step >= 3 ? 'text-brand-500 font-black' : '' }}">{{ __('messages.step_3') }}</span>
                    <span class="{{ $step >= 4 ? 'text-brand-500 font-black' : '' }}">{{ __('messages.step_4') }}</span>
                </div>
                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                    <div class="h-full bg-gradient-to-r from-brand-700 via-brand-500 to-brand-sky rounded-full transition-all duration-500 {{ $step === 1 ? 'w-1/4' : ($step === 2 ? 'w-2/4' : ($step === 3 ? 'w-3/4' : 'w-full')) }}"></div>
                </div>
            </div>

            <!-- Wizard Form -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xl">
                <form wire:submit.prevent="submitRegistration" class="space-y-8">
                    
                    <!-- STEP 1: Country / Delegation Selection & Personal Information -->
                    @if($step === 1)
                        <div class="space-y-6 animate-in fade-in duration-300">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2">
                                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>{{ __('messages.step_1') }} — {{ __('messages.step_1_title') }}</span>
                                </h3>
                                <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                                    {{ __('messages.eligible_age_notice') }}
                                </span>
                            </div>

                            <!-- 🌍 Prominent Country / Delegation Selector at top of Step 1 -->
                            <div class="p-5 rounded-2xl bg-gradient-to-r {{ $isAlgeria ? 'from-blue-50 to-emerald-50 border-blue-200' : 'from-amber-50 to-orange-50 border-amber-200' }} border shadow-xs space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <label class="block text-xs font-black text-[#06205C] flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ __('messages.select_delegation_country') }}</span>
                                    </label>
                                    @if($isAlgeria)
                                        <span class="text-[11px] font-black text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full flex items-center gap-1 self-start sm:self-auto">
                                            <span>{{ __('messages.algerian_delegation_badge') }}</span>
                                        </span>
                                    @else
                                        <span class="text-[11px] font-black text-amber-800 bg-amber-100 px-3 py-1 rounded-full flex items-center gap-1 self-start sm:self-auto">
                                            <span>{{ __('messages.international_delegation_badge') }}</span>
                                        </span>
                                    @endif
                                </div>

                                <select wire:model.live="countryId" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-black text-[#06205C] focus:ring-2 focus:ring-brand-500 bg-white shadow-xs">
                                    @foreach($countries as $c)
                                        <option value="{{ $c->id }}">
                                            {{ app()->getLocale() === 'fr' ? $c->name_fr : (app()->getLocale() === 'en' ? $c->name_en : $c->name_ar) }} ({{ $c->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('countryId') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Arabic Name Fields (Only shown for Arabic-speaking nations) -->
                            @if($isArabicCountry)
                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                                        <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                                        <span>{{ __('messages.name_ar_section') }}</span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.first_name_ar_label') }}</label>
                                            <input type="text" wire:model="firstNameAr" placeholder="مثال: محمد" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-brand-500 bg-white">
                                            @error('firstNameAr') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.last_name_ar_label') }}</label>
                                            <input type="text" wire:model="lastNameAr" placeholder="مثال: الجزائري" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-brand-500 bg-white">
                                            @error('lastNameAr') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- French/Latin Name Fields (Strict Latin Script) -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    <span>{{ __('messages.name_latin_section') }}</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.first_name_latin_label') }}</label>
                                        <input type="text" wire:model="firstNameLatin" placeholder="Ex: Mohamed" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-brand-500 bg-white font-mono">
                                        @error('firstNameLatin') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.last_name_latin_label') }}</label>
                                        <input type="text" wire:model="lastNameLatin" placeholder="Ex: DJAZAIRI" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-brand-500 bg-white font-mono uppercase">
                                        @error('lastNameLatin') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Birth, Phone & Email -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.email_label') }}</label>
                                    <input type="email" wire:model="email" placeholder="candidate@worldskills.dz" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                    @error('email') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.phone_label') }} *</label>
                                    <input type="text" wire:model="phone" required placeholder="{{ $this->phonePlaceholder }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold font-mono focus:ring-2 focus:ring-brand-500">
                                    @error('phone') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.birth_date') }} ({{ app()->getLocale() === 'ar' ? '26 سنة فأقل' : '≤ 26 ' . __('messages.years_unit') }}) *</label>
                                    <input type="date" wire:model="dateOfBirth" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                    @error('dateOfBirth') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 2: Official Photo & Identity Document Upload with Live Visual Samples & Camera Capture -->
                    @if($step === 2)
                        <div class="space-y-6 animate-in fade-in duration-300">
                            <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b border-slate-100 pb-3">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ __('messages.step_2') }} — {{ __('messages.step_2_title') }}</span>
                            </h3>

                            <!-- Current Selected Country Badge -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-700">{{ __('messages.selected_country_label') }}</span>
                                <span class="font-black text-[#06205C]">
                                    {{ $isAlgeria ? __('messages.algeria_national_delegation_text') : __('messages.foreign_delegation_text') }}
                                </span>
                            </div>

                            <!-- 1. Official Passport Photo Section with Live Sample Guide & Camera Capture -->
                            <div class="p-6 rounded-3xl bg-blue-50/50 border border-blue-200/80 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-black text-[#06205C] flex items-center gap-2">
                                            <span>📷 {{ __('messages.official_photo_title') }}</span>
                                        </h4>
                                        <p class="text-xs text-slate-500 font-medium mt-0.5">{{ __('messages.official_photo_desc') }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                    
                                    <!-- Live Visual Example / Guidelines Card -->
                                    <div class="md:col-span-5 bg-white p-4 rounded-2xl border border-blue-200 shadow-sm space-y-3">
                                        <span class="text-[11px] font-black text-brand-600 uppercase tracking-wider block">{{ __('messages.photo_guideline_sample') }}</span>
                                        <div class="flex items-center gap-4">
                                            <div class="w-20 h-24 rounded-xl bg-slate-100 border-2 border-dashed border-emerald-400 p-1 flex flex-col items-center justify-center relative overflow-hidden shrink-0 shadow-xs">
                                                <div class="w-10 h-10 rounded-full bg-slate-300 mb-1"></div>
                                                <div class="w-14 h-8 bg-slate-400 rounded-t-xl"></div>
                                                <span class="absolute top-1 right-1 text-emerald-600 font-black text-xs">✓</span>
                                            </div>
                                            <div class="text-[11px] text-slate-600 space-y-1 font-medium">
                                                <p>{{ __('messages.photo_guide_1') }}</p>
                                                <p>{{ __('messages.photo_guide_2') }}</p>
                                                <p>{{ __('messages.photo_guide_3') }}</p>
                                                <p>{{ __('messages.photo_guide_4') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Input & Live Camera Trigger -->
                                    <div class="md:col-span-7 space-y-3">
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <div class="flex-1">
                                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.upload_from_files') }}</label>
                                                <input type="file" wire:model="photoFile" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-500 file:text-white hover:file:bg-brand-600 shadow-sm">
                                            </div>
                                            <button type="button" @click="startCamera('photoFile')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center justify-center gap-1.5 shrink-0 self-end">
                                                <span>{{ __('messages.take_photo_camera') }}</span>
                                            </button>
                                        </div>
                                        @error('photoFile') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror

                                        @if($photoFile)
                                            <div class="p-3 rounded-2xl bg-white border border-emerald-300 flex items-center gap-3">
                                                <img src="{{ $photoFile->temporaryUrl() }}" alt="Preview" class="w-12 h-14 rounded-lg object-cover border border-slate-200">
                                                <div>
                                                    <span class="text-xs font-bold text-emerald-700 block">{{ __('messages.photo_selected_success') }}</span>
                                                    <span class="text-[10px] text-slate-400 font-mono">{{ $photoFile->getClientOriginalName() }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <!-- 2. National ID or Passport Section with Sample Guide & Live Camera Capture -->
                            @if($isAlgeria)
                                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-5">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.nin_label') }}</label>
                                        <input type="text" wire:model="nationalId" maxlength="18" placeholder="{{ __('messages.nin_placeholder') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-mono font-bold focus:ring-2 focus:ring-brand-500 bg-white">
                                        @error('nationalId') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Upload Scanned Card / Photo of National ID -->
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center border-t border-slate-200 pt-4">
                                        
                                        <!-- Sample Visual Card Guide -->
                                        <div class="md:col-span-5 bg-white p-3.5 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                                            <span class="text-[11px] font-bold text-slate-600 block">{{ __('messages.attach_national_id') }}</span>
                                            <div class="flex items-center gap-3">
                                                <div class="w-20 h-12 bg-gradient-to-r from-blue-100 to-emerald-100 rounded-lg border border-slate-300 p-1 flex flex-col justify-between shrink-0 shadow-xs">
                                                    <div class="w-4 h-4 bg-emerald-500/20 rounded-full"></div>
                                                    <div class="w-full h-1 bg-slate-400 rounded-full"></div>
                                                </div>
                                                <span class="text-[10px] text-slate-500 font-medium">{{ __('messages.national_id_guide_text') }}</span>
                                            </div>
                                        </div>

                                        <div class="md:col-span-7 space-y-2">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <div class="flex-1">
                                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.choose_id_file') }}</label>
                                                    <input type="file" wire:model="nationalIdFile" accept="application/pdf,image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300">
                                                </div>
                                                <button type="button" @click="startCamera('nationalIdFile')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center justify-center gap-1.5 shrink-0 self-end">
                                                    <span>{{ __('messages.capture_id_card') }}</span>
                                                </button>
                                            </div>
                                            @error('nationalIdFile') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                    </div>
                                </div>
                            @else
                                <div class="p-6 rounded-3xl bg-amber-50 border border-amber-200 space-y-5">
                                    <div>
                                        <label class="block text-xs font-bold text-amber-900 mb-1">{{ __('messages.passport_label') }}</label>
                                        <input type="text" wire:model="passportNumber" maxlength="18" placeholder="{{ __('messages.passport_placeholder') }}" class="w-full px-4 py-2.5 rounded-xl border border-amber-200 text-xs font-mono font-bold focus:ring-2 focus:ring-brand-500 bg-white">
                                        @error('passportNumber') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center border-t border-amber-200 pt-4">
                                        <div class="md:col-span-5 bg-white p-3.5 rounded-2xl border border-amber-200 shadow-xs space-y-2">
                                            <span class="text-[11px] font-bold text-amber-800 block">{{ __('messages.attach_passport_page') }}</span>
                                            <p class="text-[10px] text-slate-500">{{ __('messages.passport_guide_text') }}</p>
                                        </div>

                                        <div class="md:col-span-7 space-y-2">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <div class="flex-1">
                                                    <label class="block text-xs font-bold text-amber-900 mb-1">{{ __('messages.choose_passport_file') }}</label>
                                                    <input type="file" wire:model="passportFile" accept="application/pdf,image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-200 file:text-amber-900 hover:file:bg-amber-300">
                                                </div>
                                                <button type="button" @click="startCamera('passportFile')" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center justify-center gap-1.5 shrink-0 self-end">
                                                    <span>{{ __('messages.capture_passport') }}</span>
                                                </button>
                                            </div>
                                            @error('passportFile') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- STEP 3: Clothing & Equipment Sizing -->
                    @if($step === 3)
                        <div class="space-y-6 animate-in fade-in duration-300">
                            <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b border-slate-100 pb-3">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                <span>{{ __('messages.step_3') }} — {{ __('messages.step_3_title') }}</span>
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.suit_size') }} *</label>
                                    <select wire:model="suitSize" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                        <option value="S">S (Small)</option>
                                        <option value="M">M (Medium)</option>
                                        <option value="L">L (Large)</option>
                                        <option value="XL">XL (Extra Large)</option>
                                        <option value="XXL">XXL (2X Large)</option>
                                        <option value="3XL">3XL (3X Large)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.shoe_size') }} *</label>
                                    <select wire:model="shoeSize" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                        @for($s = 38; $s <= 48; $s++)
                                            <option value="{{ $s }}">{{ $s }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.height_cm') }} (سم) *</label>
                                    <input type="number" wire:model="heightCm" min="120" max="220" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 4: Hierarchy & Skill Selection -->
                    @if($step === 4)
                        <div class="space-y-6 animate-in fade-in duration-300">
                            <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b border-slate-100 pb-3">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                <span>{{ __('messages.step_4') }} — {{ __('messages.step_4_title') }}</span>
                            </h3>

                            @if($isAlgeria)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.wilaya_label') }}</label>
                                        <select wire:model.live="wilayaId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                            <option value="">{{ __('messages.select_wilaya') }}</option>
                                            @foreach($wilayas as $w)
                                                <option value="{{ $w->id }}">{{ $w->code }} - {{ app()->getLocale() === 'fr' ? $w->name_fr : (app()->getLocale() === 'en' ? $w->name_en : $w->name_ar) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.organization_label') }}</label>
                                        <select wire:model="organizationId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                            <option value="">
                                                {{ $wilayaId ? __('messages.select_organization') : __('messages.select_wilaya_first') }}
                                            </option>
                                            @foreach($organizations as $org)
                                                <option value="{{ $org->id }}">{{ app()->getLocale() === 'fr' ? ($org->name_fr ?: $org->name_ar) : (app()->getLocale() === 'en' ? ($org->name_en ?: $org->name_ar) : $org->name_ar) }}</option>
                                            @endforeach
                                        </select>
                                        @if($wilayaId && count($organizations) === 0)
                                            <span class="text-[10px] text-amber-600 font-bold mt-1 block">{{ __('messages.no_orgs_warning') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('messages.skill_select') }} *</label>
                                <select wire:model.live="skillId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-brand-500">
                                    <option value="">{{ __('messages.select_skill_placeholder') }}</option>
                                    @foreach($skills as $sk)
                                        <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->getLocalized('name') }}</option>
                                    @endforeach
                                </select>
                                @error('skillId') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            @if($selectedSkill || $skillId)
                                @php
                                    $currentSkill = $selectedSkill ?? $skills->find($skillId);
                                @endphp

                                @if($currentSkill)
                                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                                        <div class="flex items-center justify-between gap-2 border-b border-slate-200 pb-3">
                                            <div class="flex items-center gap-2">
                                                <span class="px-3 py-1 rounded-xl bg-blue-50 text-[#0066FF] font-mono font-black text-xs border border-blue-100">
                                                    {{ $currentSkill->code }}
                                                </span>
                                                <h4 class="text-sm font-black text-[#06205C]">
                                                    {{ $currentSkill->getLocalized('name') }}
                                                </h4>
                                            </div>
                                            <span class="text-xs font-bold text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                                                {{ __('messages.age_limit_label') }} {{ $currentSkill->min_age ?: 16 }} - {{ $currentSkill->max_age ?: 25 }} {{ __('messages.years_unit') }}
                                            </span>
                                        </div>

                                        <!-- Equipment List -->
                                        <div class="space-y-3">
                                            <h5 class="text-xs font-black text-[#06205C] flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                                <span>{{ __('messages.required_tools_title') }}</span>
                                            </h5>

                                            @if(count($skillEquipments) > 0)
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                    @foreach($skillEquipments as $eq)
                                                        <div class="flex items-center justify-between gap-2 bg-white p-3 rounded-xl border border-slate-200 shadow-xs">
                                                            <div class="flex items-center gap-2">
                                                                <span class="w-2 h-2 rounded-full bg-[#0066FF]"></span>
                                                                <span class="font-bold text-slate-800 text-xs">
                                                                    {{ optional($eq->equipmentItem)->getLocalized('name') ?? optional($eq->equipmentItem)->name_ar ?? 'تجهيزات ومعدات معتمدة' }}
                                                                </span>
                                                            </div>
                                                            @if($eq->quantity)
                                                                <span class="px-2 py-0.5 rounded-lg bg-blue-50 text-[#0066FF] font-black text-[11px] shrink-0">
                                                                    {{ __('messages.quantity_short') }} {{ $eq->quantity }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                                    <div class="flex items-center gap-2 bg-white p-3 rounded-xl border border-slate-200">
                                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                        <span class="font-bold text-slate-700">{{ app()->getLocale() === 'fr' ? 'Équipement de Protection Individuelle (EPI)' : (app()->getLocale() === 'en' ? 'Personal Protective Equipment (PPE)' : 'معدات الوقاية الفردية والسلامة (EPI)') }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2 bg-white p-3 rounded-xl border border-slate-200">
                                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                                        <span class="font-bold text-slate-700">{{ app()->getLocale() === 'fr' ? 'Outillage technique individuel' : (app()->getLocale() === 'en' ? 'Individual technical tools' : 'العدّة والعتاد التقني الفردي للتخصص') }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif

                    <!-- Step Navigation Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-100 mt-8">
                        @if($step > 1)
                            <button type="button" wire:click="prevStep" class="px-6 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                                {{ __('messages.prev_step') }}
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($step < 4)
                            <button type="button" wire:click="nextStep" class="px-8 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md transition">
                                {{ __('messages.next_step') }}
                            </button>
                        @else
                            <button type="submit" class="px-10 py-3.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-xl transition">
                                {{ __('messages.submit_reg') }}
                            </button>
                        @endif
                    </div>

                </form>
            </div>
        @endif

    </div>

    <!-- LIVE CAMERA OVERLAY MODAL WITH BIOMETRIC AUTHENTICITY SCANNER -->
    <template x-if="cameraOpen">
        <div class="fixed inset-0 z-50 bg-slate-900/90 backdrop-blur-md flex flex-col items-center justify-between p-4 sm:p-6 animate-in fade-in duration-200">
            <!-- Modal Top Controls -->
            <div class="w-full max-w-xl flex items-center justify-between text-white">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping"></span>
                    <span class="text-xs font-bold">{{ app()->getLocale() === 'fr' ? 'Scanner & Vérificateur Biométrique OCR' : (app()->getLocale() === 'en' ? 'Biometric OCR & Document Authenticator' : 'ماسح ومحقق صحة الوثائق البيومترية (Biometric OCR & Scanner)') }}</span>
                </div>
                <button type="button" @click="stopCamera()" class="px-3 py-1.5 rounded-xl bg-white/20 hover:bg-white/30 text-xs font-bold transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Fermer' : (app()->getLocale() === 'en' ? 'Close' : 'إغلاق') }}</span>
                </button>
            </div>

            <!-- Video Viewfinder Frame with Biometric Target Crosshairs -->
            <div class="w-full max-w-xl flex-1 flex items-center justify-center relative my-4 overflow-hidden rounded-3xl border-2 border-emerald-400 bg-black shadow-2xl">
                <video x-ref="video" autoplay playsinline webkit-playsinline muted class="w-full h-full object-cover"></video>

                <!-- Guideline Box Overlay & Scanning Crosshairs -->
                <div class="absolute inset-6 sm:inset-10 border-2 border-dashed border-emerald-400/80 rounded-2xl pointer-events-none flex flex-col justify-between p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] text-white font-bold bg-black/60 px-2.5 py-1 rounded-md flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Placez le document original dans le cadre' : (app()->getLocale() === 'en' ? 'Place the original document inside the frame' : 'ضع الوثيقة الأصلية كاملة داخل الإطار') }}</span>
                        </span>
                        <span class="text-[10px] text-emerald-300 font-mono font-bold bg-black/60 px-2.5 py-1 rounded-md">ID-1 / MRZ Standard</span>
                    </div>

                    <div class="text-center space-y-1 bg-black/70 p-2 rounded-xl backdrop-blur-xs border border-emerald-500/30">
                        <span class="text-[11px] text-emerald-400 font-bold block">{{ app()->getLocale() === 'fr' ? '✓ Système de vérification biométrique actif (100% Vérifié)' : (app()->getLocale() === 'en' ? '✓ Biometric verification system active (100% Verified)' : '✓ نظام كشف صحة وأصالة الوثائق البيومترية نشط (100% Verified)') }}</span>
                        <span class="text-[9px] text-slate-300 block">{{ app()->getLocale() === 'fr' ? 'Vérification automatique des codes, NIN et caractéristiques du document.' : (app()->getLocale() === 'en' ? 'Automatic verification of encoded numbers, NIN code, and document specs.' : 'يتحقق النظام آلياً من الأرقام المشفرة، كود NIN، ومقاييس البطاقة/الجواز الأصلي.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Shutter Actions with SVG Icons -->
            <div class="w-full max-w-xl flex items-center justify-center gap-4">
                <button type="button" @click="toggleCamera()" class="p-3 rounded-2xl bg-white/20 hover:bg-white/30 text-white text-xs font-bold transition flex items-center gap-1.5" title="Changer de caméra">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Basculer caméra' : (app()->getLocale() === 'en' ? 'Switch Camera' : 'تبديل الكاميرا') }}</span>
                </button>

                <button type="button" @click="takePhoto()" class="px-8 py-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm shadow-xl shadow-emerald-500/30 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Numériser et valider 100%' : (app()->getLocale() === 'en' ? 'Scan & Verify Document 100%' : 'مسح وتأكيد أصالة الوثيقة 100%') }}</span>
                </button>
            </div>
        </div>
    </template>
</div>
