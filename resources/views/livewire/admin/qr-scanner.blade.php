@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="max-w-4xl mx-auto space-y-6 pb-12"
    x-data="{
         cameraOpen: false,
         stream: null,
         animFrame: null,
         async startCamera() {
             this.cameraOpen = true;
             let s = null;
             try {
                 s = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
             } catch (e1) {
                 try {
                     s = await navigator.mediaDevices.getUserMedia({ video: true });
                 } catch (e2) {
                     alert('{{ $t('تعذر فتح الكاميرا: يرجى التأكد من السماح بصلاحيات الكاميرا في المتصفح، أو استخدام إدخال الكود يدويًا.', 'Impossible d\'ouvrir la caméra. Veuillez autoriser la caméra ou utiliser la recherche manuelle.', 'Unable to open camera. Please allow camera permissions or use manual search.') }}');
                     this.cameraOpen = false;
                     return;
                 }
             }

             this.stream = s;
             $refs.scanVideo.srcObject = s;

             if ('BarcodeDetector' in window) {
                 const detector = new BarcodeDetector({ formats: ['qr_code'] });
                 const scanLoop = () => {
                     if (!this.cameraOpen) return;
                     detector.detect($refs.scanVideo).then(codes => {
                         if (codes.length > 0) {
                             $wire.set('query', codes[0].rawValue);
                             $wire.scan();
                             this.stopCamera();
                         } else {
                             this.animFrame = requestAnimationFrame(scanLoop);
                         }
                     }).catch(() => {
                         this.animFrame = requestAnimationFrame(scanLoop);
                     });
                 };
                 scanLoop();
             }
         },
         stopCamera() {
             if (this.animFrame) cancelAnimationFrame(this.animFrame);
             if (this.stream) this.stream.getTracks().forEach(t => t.stop());
             this.cameraOpen = false;
         }
     }">

    {{-- HEADER --}}
    <div class="flex items-center justify-between bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#06205C] text-white flex items-center justify-center shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m8-8h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-[#06205C] dark:text-white">
                    {{ $t('ماسح الـ QR والأثر الأمني الموحد للشارات', 'Scanner QR & Contrôle Sécurisé', 'Security QR Code Scanner') }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    {{ $t('التحقق الميداني الموحد من هويات واستحقاقات جميع الكوادر والمشاركين والحكام ورؤساء الوفود.', 'Vérification en temps réel des accréditations, candidats, juges et chefs de délégation.', 'Real-time field verification for candidates, experts, judges and delegation members.') }}
                </p>
            </div>
        </div>

        <div class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 text-xs font-black border border-emerald-300">
            WSAP SECURITY LIVE
        </div>
    </div>

    {{-- SCAN INPUT FORM --}}
    <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-md space-y-4">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                {{ $t('امسح الكود بالكاميرا المباشرة أو أدخل كود الشارة / UUID يدوياً *', 'Scannez le QR avec la caméra ou saisissez le code/UUID manuellement *', 'Scan QR via live camera or enter Badge UUID manually *') }}
            </label>
            <button type="button" @click="cameraOpen ? stopCamera() : startCamera()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border text-xs font-black transition shadow-xs bg-slate-50 hover:bg-[#06205C] hover:text-white border-slate-200 text-slate-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                </svg>
                <span x-text="cameraOpen ? '{{ $t('إغلاق الكاميرا', 'Fermer Caméra', 'Close Camera') }}' : '{{ $t('فتح الكاميرا لمسح الـ QR', 'Ouvrir Caméra QR', 'Open QR Camera') }}'"></span>
            </button>
        </div>

        {{-- CAMERA FEED --}}
        <div x-show="cameraOpen" x-transition class="space-y-3 pt-2">
            <div class="relative w-full max-w-sm mx-auto aspect-square rounded-3xl overflow-hidden border-2 border-[#06205C]/30 shadow-xl bg-slate-900">
                <video x-ref="scanVideo" autoplay playsinline muted class="w-full h-full object-cover"></video>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="relative w-48 h-48">
                        <span class="absolute top-0 start-0 w-8 h-8 border-t-4 border-s-4 border-[#06205C] rounded-tl-xl"></span>
                        <span class="absolute top-0 end-0 w-8 h-8 border-t-4 border-e-4 border-[#06205C] rounded-tr-xl"></span>
                        <span class="absolute bottom-0 start-0 w-8 h-8 border-b-4 border-s-4 border-[#06205C] rounded-bl-xl"></span>
                        <span class="absolute bottom-0 end-0 w-8 h-8 border-b-4 border-e-4 border-[#06205C] rounded-br-xl"></span>
                    </div>
                </div>
                <div class="absolute bottom-4 inset-x-0 text-center">
                    <span class="inline-block px-4 py-1.5 bg-black/60 backdrop-blur-md text-white text-xs font-bold rounded-full">
                        {{ $t('وجّه كاميرا الجهاز نحو كود الـ QR', 'Orientez la caméra vers le code QR', 'Point camera towards the QR code') }}
                    </span>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="scan" class="space-y-3">
            <div class="flex gap-2">
                <input type="text" wire:model.defer="query" autofocus
                    placeholder="{{ $t('أدخل UUID الشارة أو التوكين أو معرف المستخدم...', 'Saisissez le code UUID ou l\'ID du badge...', 'Enter Badge UUID, Token or User ID...') }}"
                    class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-sm font-bold bg-slate-50 dark:bg-slate-900 dark:text-slate-100 focus:bg-white transition">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs transition shadow-md">
                    {{ $t('فحص وتفكيك الـ QR', 'Vérifier & Analyser', 'Verify & Scan QR') }}
                </button>
            </div>
        </form>
    </div>

    {{-- ACCESS DECISION RESULT CARD --}}
    @if(!empty($accessDecision))
    <div class="p-6 rounded-3xl border shadow-lg space-y-4 {{ $accessDecision['is_allowed'] ? 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-300 dark:border-emerald-700 text-emerald-950 dark:text-emerald-100' : 'bg-rose-50 dark:bg-rose-950/40 border-rose-300 dark:border-rose-700 text-rose-950 dark:text-rose-100' }}">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-white font-black text-lg {{ $accessDecision['is_allowed'] ? 'bg-emerald-600' : 'bg-rose-600' }}">
                    {!! $accessDecision['is_allowed']
                    ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>'
                    : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>' !!}
                </div>
                <div>
                    <h2 class="text-xl font-black">
                        {{ $accessDecision['is_allowed']
                            ? $t('إذن وصول مقبول ومصرح به 100%', 'Accès Autorisé & Accrédité 100%', 'Access Granted & Authorized 100%')
                            : $t('وصول مرفوض ومحظور أمنياً!', 'Accès Refusé & Interdit !', 'Access Denied & Restricted!') }}
                    </h2>
                    <p class="text-xs font-bold opacity-80">
                        {{ $locale === 'fr' ? ($accessDecision['message_fr'] ?? $accessDecision['message_ar']) : ($locale === 'en' ? ($accessDecision['message_en'] ?? $accessDecision['message_ar']) : $accessDecision['message_ar']) }}
                    </p>
                </div>
            </div>

            <div class="text-end">
                <span class="px-3 py-1 rounded-full text-xs font-black font-mono border bg-white/80 dark:bg-slate-800">
                    CODE: {{ $accessDecision['reason_code'] }}
                </span>
            </div>
        </div>

        @if(!$accessDecision['is_allowed'])
        <div class="pt-2 flex justify-end">
            <button wire:click="$set('showOverrideModal', true)" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md">
                {{ $t('تجاوز طارئ من مدير النظام (Super Admin Override)', 'Dérogation Exceptionnelle (Super Admin)', 'Super Admin Emergency Override') }}
            </button>
        </div>
        @endif
    </div>
    @endif

    {{-- ACCREDITED USER FULL DOSSIER --}}
    @if($scannedUser)
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-xl overflow-hidden">

        {{-- TOP HEADER BAND --}}
        <div class="bg-gradient-to-l from-[#06205C] to-[#0A3580] p-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-2xl border-2 border-white/30 overflow-hidden shrink-0 shadow-lg bg-white/10">
                    <img src="{{ $scannedUser->avatar_url }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-xl font-black text-white">{{ $delegationMember?->full_name ?: $scannedUser->name }}</h3>
                    <p class="text-blue-200 text-xs font-medium">{{ $scannedUser->email }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @php $role = $delegationMember?->member_type ?: ($scannedUser->roles->first()?->name ?: 'MEMBER'); @endphp
                        <span class="px-3 py-1 rounded-full text-[11px] font-black bg-amber-400 text-slate-900 border border-amber-300 uppercase">
                            {{ $role }}
                        </span>
                        @if($scannedUser->is_active)
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-400/20 text-emerald-300 border border-emerald-400/40">
                            {{ $t('نشط', 'ACTIF', 'ACTIVE') }}
                        </span>
                        @else
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-400/20 text-rose-300 border border-rose-400/40">
                            {{ $t('معطل', 'INACTIF', 'INACTIVE') }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Badge Status --}}
            @if($scannedBadge)
            <div class="text-start space-y-1.5">
                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-black
                    {{ $scannedBadge->status === 'ACTIVE' ? 'bg-emerald-400 text-emerald-950' : 'bg-rose-400 text-rose-950' }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $scannedBadge->status }}
                </span>
                <div class="text-[9px] font-mono text-blue-200 text-right leading-relaxed">
                    <div>UUID: {{ substr($scannedBadge->badge_uuid, 0, 18) }}...</div>
                </div>
                <div class="text-[10px] text-blue-300 font-bold flex items-center gap-1 justify-end">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ now()->format('H:i:s') }} — {{ now()->format('Y/m/d') }}
                </div>
            </div>
            @endif
        </div>

        {{-- BODY DOSSIER --}}
        <div class="p-6 space-y-5">

            {{-- DIETARY & MEDICAL ALLERGY ALERT CARD --}}
            @if($delegationMember && (!empty($delegationMember->dietary_requirements) || !empty($delegationMember->dietary_notes)))
                <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-700/80 text-slate-900 dark:text-amber-100 space-y-2 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-amber-900 dark:text-amber-300 font-black text-xs">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>{{ $t('تنبيه الإطعام والمطبخ: حساسية طعام ونظام غذائي خاص', 'Alerte Restauration: Régime & Allergies Spéciales', 'Catering Alert: Food Allergies & Dietary Restriction') }}</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-600 text-white font-black text-[10px] uppercase">
                            {{ $t('مهم للمطعم والخدمات الطبية', 'IMPORTANT RESTAURATION', 'CATERING ALERT') }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @php
                            $dietaryMap = [
                                'GLUTEN_FREE'     => 'خالي من الغلوتين / Sans Gluten',
                                'LACTOSE_FREE'    => 'خالي من اللاكتوز / Sans Lactose',
                                'NUT_ALLERGY'     => 'حساسية المكسرات / Allergie Fruits à Coque',
                                'SEAFOOD_ALLERGY' => 'حساسية البحرية / Allergie Fruits de Mer',
                                'HALAL_ONLY'      => 'حلال فقط / Halal Only',
                                'VEGETARIAN'      => 'نباتي / Végétarien',
                                'VEGAN'           => 'نباتي تام / Vegan',
                                'DIABETIC'        => 'حمية سكري / Diabétique',
                            ];
                        @endphp
                        @if(is_array($delegationMember->dietary_requirements))
                            @foreach($delegationMember->dietary_requirements as $reqCode)
                                @php $infoLabel = $dietaryMap[$reqCode] ?? $reqCode; @endphp
                                <span class="px-2.5 py-1 rounded-xl text-[11px] font-black bg-amber-200/80 dark:bg-amber-900 text-amber-950 dark:text-amber-100 border border-amber-300 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-700 dark:text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>{{ $infoLabel }}</span>
                                </span>
                            @endforeach
                        @endif
                    </div>

                    @if($delegationMember->dietary_notes)
                        <p class="text-xs font-bold text-amber-900 dark:text-amber-200 bg-white/70 dark:bg-slate-900/60 p-2.5 rounded-xl border border-amber-200 dark:border-amber-800/60">
                            <strong>{{ $t('ملاحظات المطبخ: ', 'Notes Cuisine: ', 'Kitchen Notes: ') }}</strong> {{ $delegationMember->dietary_notes }}
                        </p>
                    @endif
                </div>
            @endif

            {{-- ROW 1: Country | Role/Skill | Identity | Contact --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                {{-- Country & Delegation --}}
                <div class="bg-blue-50 dark:bg-blue-950/30 p-3.5 rounded-2xl border border-blue-200/60 dark:border-blue-900/60 space-y-1">
                    <span class="text-blue-500 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $t('الدولة / الوفد', 'Pays / Délégation', 'Country / Delegation') }}
                    </span>
                    <span class="text-[#06205C] dark:text-blue-200 block font-black text-xs">
                        {{ $locale === 'fr' ? ($scannedUser->country?->name_fr ?: 'Algérie') : ($locale === 'en' ? ($scannedUser->country?->name_en ?: 'Algeria') : ($scannedUser->country?->name_ar ?: 'الجزائر')) }}
                    </span>
                    <span class="text-slate-500 block text-[11px] font-mono">
                        {{ $scannedUser->country?->code ?: 'DZA' }}
                    </span>
                </div>

                {{-- Role & Skill --}}
                <div class="bg-amber-50 dark:bg-amber-950/30 p-3.5 rounded-2xl border border-amber-200/60 dark:border-amber-900/60 space-y-1">
                    <span class="text-amber-600 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        {{ $t('الصفة / الدور', 'Rôle / Discipline', 'Role / Skill') }}
                    </span>
                    <span class="text-slate-900 dark:text-slate-100 block font-black text-xs">{{ $role }}</span>
                    @if($delegationMember?->skill)
                    <span class="text-amber-700 dark:text-amber-400 block text-[11px] font-bold">
                        {{ $delegationMember->skill->code }} — {{ $locale === 'fr' ? ($delegationMember->skill->name_fr ?: $delegationMember->skill->name_ar) : ($locale === 'en' ? ($delegationMember->skill->name_en ?: $delegationMember->skill->name_ar) : $delegationMember->skill->name_ar) }}
                    </span>
                    @else
                    <span class="text-slate-400 block text-[11px]">—</span>
                    @endif
                </div>

                {{-- Identity Docs --}}
                <div class="bg-purple-50 dark:bg-purple-950/30 p-3.5 rounded-2xl border border-purple-200/60 dark:border-purple-900/60 space-y-1">
                    <span class="text-purple-500 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        {{ $t('وثائق الهوية', 'Pièces d\'identité', 'Identity Documents') }}
                    </span>
                    <span class="text-slate-900 dark:text-slate-100 block font-mono font-black text-[11px]">
                        {{ $t('جواز: ', 'Passeport: ', 'Passport: ') }} {{ $delegationMember?->passport_number ?: '—' }}
                    </span>
                    <span class="text-slate-600 dark:text-slate-400 block font-mono text-[11px]">
                        NIN: {{ $delegationMember?->nin_number ?: '—' }}
                    </span>
                </div>

                {{-- Contact --}}
                <div class="bg-teal-50 dark:bg-teal-950/30 p-3.5 rounded-2xl border border-teal-200/60 dark:border-teal-900/60 space-y-1">
                    <span class="text-teal-600 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $t('التواصل', 'Contact', 'Contact Info') }}
                    </span>
                    <span class="text-slate-900 dark:text-slate-100 block font-bold text-[11px]">
                        {{ $delegationMember?->phone ?: $scannedUser->phone ?? '—' }}
                    </span>
                    <span class="text-slate-500 block text-[11px] truncate">
                        {{ $delegationMember?->email ?: $scannedUser->email }}
                    </span>
                </div>
            </div>

            {{-- ROW 2: Room | Flights | Sizes | System Info --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                {{-- Room --}}
                <div class="bg-indigo-50 dark:bg-indigo-950/30 p-3.5 rounded-2xl border border-indigo-200/60 dark:border-indigo-900/60 space-y-1">
                    <span class="text-indigo-500 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $t('الغرفة / الإقامة', 'Chambre / Logement', 'Room / Accommodation') }}
                    </span>
                    <span class="text-indigo-900 dark:text-indigo-200 block font-black text-xs">
                        {{ $roomAllocation?->room?->accommodation?->name_ar ?: $t('القرية الأورومتوسطية', 'Village Euroméditerranéen', 'Euro-Mediterranean Village') }}
                    </span>
                    <span class="text-emerald-700 dark:text-emerald-400 block font-bold text-[11px]">
                        {{ $roomAllocation?->room?->room_number ? ($t('غرفة ', 'Chambre ', 'Room ') . $roomAllocation->room->room_number) : $t('لم تحدد بعد', 'Non assignée', 'Not assigned yet') }}
                    </span>
                    @if($roomAllocation?->status)
                    <span class="text-[10px] {{ $roomAllocation->status === 'CONFIRMED' ? 'text-emerald-600' : 'text-amber-600' }} font-bold">
                        {{ $roomAllocation->status }}
                    </span>
                    @endif
                </div>

                {{-- Flights --}}
                <div class="bg-sky-50 dark:bg-sky-950/30 p-3.5 rounded-2xl border border-sky-200/60 dark:border-sky-900/60 space-y-1">
                    <span class="text-sky-600 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        {{ $t('رحلة الوصول', 'Vol d\'arrivée', 'Arrival Flight') }}
                    </span>
                    <span class="text-slate-900 dark:text-slate-100 block font-bold text-[11px]">
                        {{ $delegationMember?->arrival_flight ?: '—' }}
                    </span>
                    <span class="text-sky-600 text-[10px] font-black uppercase tracking-wider mt-0.5 flex items-center gap-1.5">
                        <svg class="w-3 h-3 shrink-0 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        {{ $t('رحلة المغادرة', 'Vol de départ', 'Departure Flight') }}
                    </span>
                    <span class="text-slate-900 dark:text-slate-100 block font-bold text-[11px]">
                        {{ $delegationMember?->departure_flight ?: '—' }}
                    </span>
                </div>

                {{-- Clothing Sizes --}}
                <div class="bg-rose-50 dark:bg-rose-950/30 p-3.5 rounded-2xl border border-rose-200/60 dark:border-rose-900/60 space-y-1">
                    <span class="text-rose-500 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $t('القياسات الشخصية', 'Tailles & Mesures', 'Personal Sizes') }}
                    </span>
                    <span class="text-slate-800 dark:text-slate-200 block text-[11px] font-bold flex items-center gap-1">
                        @if($delegationMember?->gender === 'female')
                        <svg class="w-3 h-3 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2a5 5 0 110 10A5 5 0 0112 2zm0 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4z" />
                        </svg> {{ $t('أنثى', 'Femme', 'Female') }}
                        @else
                        <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2a5 5 0 110 10A5 5 0 0112 2zm0 12c2.67 0 8 1.34 8 4v2H4v-2c0-2.66 5.33-4 8-4z" />
                        </svg> {{ $t('ذكر', 'Homme', 'Male') }}
                        @endif
                    </span>
                    <span class="text-slate-600 dark:text-slate-400 block text-[11px]">
                        {{ $t('بدلة: ', 'Costume: ', 'Suit: ') }} <b>{{ $delegationMember?->suit_size ?: '—' }}</b>
                        &nbsp;|&nbsp; {{ $t('حذاء: ', 'Pointure: ', 'Shoe: ') }} <b>{{ $delegationMember?->shoe_size ?: '—' }}</b>
                    </span>
                </div>

                {{-- System Info --}}
                <div class="bg-slate-50 dark:bg-slate-900/40 p-3.5 rounded-2xl border border-slate-200/60 dark:border-slate-700 space-y-1">
                    <span class="text-slate-500 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $t('معلومات النظام', 'Infos Système', 'System Info') }}
                    </span>
                    <span class="text-slate-700 dark:text-slate-300 block text-[11px] font-bold">
                        ID: #{{ $scannedUser->id }}
                    </span>
                    <span class="text-slate-500 block text-[11px]">
                        {{ $t('آخر دخول: ', 'Dernière connexion: ', 'Last Login: ') }} {{ $scannedUser->last_login_at?->format('Y/m/d H:i') ?: '—' }}
                    </span>
                    <span class="text-slate-400 block text-[10px] font-mono">
                        {{ $scannedUser->locale ?? 'ar' }}
                    </span>
                </div>
            </div>

            {{-- ROW 3: Zone Permissions --}}
            @if(!empty($zonePermissions))
            <div class="border-t border-slate-100 dark:border-slate-700 pt-4 space-y-2">
                <h4 class="text-xs font-black text-[#06205C] dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ $t('صلاحيات الدخول للمناطق الأمنية', 'Accès aux Zones Sécurisées', 'Security Zone Permissions') }}
                </h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($zonePermissions as $zp)
                    <span class="px-3 py-1.5 rounded-xl border text-[11px] font-bold flex items-center gap-2
                        {{ ($zp['permission'] ?? '') === 'ALLOW' ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-rose-50 border-rose-300 text-rose-900' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if(($zp['permission'] ?? '') === 'ALLOW')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            @endif
                        </svg>
                        {{ $locale === 'fr' ? ($zp['zone']['name_fr'] ?? $zp['zone']['name_ar'] ?? $zp['zone']['name']) : ($locale === 'en' ? ($zp['zone']['name_en'] ?? $zp['zone']['name_ar'] ?? $zp['zone']['name']) : ($zp['zone']['name_ar'] ?? $zp['zone']['name'])) }}
                        <span class="opacity-60 text-[10px]">({{ $zp['permission'] ?? 'ALLOW' }})</span>
                    </span>
                    @endforeach
                </div>
            </div>
            @else
            <div class="border-t border-slate-100 dark:border-slate-700 pt-4">
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $t('لم تحدد تصاريح مناطق مخصصة لهذه الشارة', 'Aucune zone restreinte assignée à ce badge', 'No specific zone permissions defined for this badge') }}
                </p>
            </div>
            @endif

        </div>

        {{-- FOOTER --}}
        <div class="bg-slate-50 dark:bg-slate-900/60 px-6 py-3 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between gap-4">
            <span class="text-[11px] text-slate-400 font-mono truncate">UUID: {{ $scannedBadge?->badge_uuid ?? ($scannedUser->uuid ?? '—') }}</span>
            <span class="text-[11px] font-black text-slate-500 shrink-0 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                {{ $t('فحص أمني — ', 'Contrôle Sécurité — ', 'Security Scan — ') }}{{ now()->format('d/m/Y H:i:s') }}
            </span>
        </div>
    </div>
    @endif

    {{-- SUPER ADMIN OVERRIDE MODAL --}}
    @if($showOverrideModal)
    <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <h3 class="text-base font-black text-amber-700 dark:text-amber-400">
                    {{ $t('تأكيد التجاوز الطارئ من مدير النظام', 'Dérogation Exceptionnelle Super Admin', 'Confirm Super Admin Emergency Override') }}
                </h3>
                <button wire:click="$set('showOverrideModal', false)" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <p class="text-slate-600 dark:text-slate-300 font-bold">
                    {{ $t('أنت على وشك منح تجاوز استثنائي لهذه الشارة. يرجى إدخال السبب الإلزامي لتسجيله في سجلات التدقيق الأمني.', 'Vous êtes sur le point d\'accorder une dérogation exceptionnelle. Veuillez indiquer le motif obligatoire.', 'You are about to issue an emergency override. Please enter mandatory reason for audit log.') }}
                </p>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
                        {{ $t('السبب الإلزامي للتجاوز *', 'Motif obligatoire *', 'Mandatory Reason *') }}
                    </label>
                    <textarea wire:model="overrideReasonAr" required rows="3"
                        placeholder="{{ $t('مثال: إذن خاص صادر من اللجنة التنفيذية للاجتماع الطارئ...', 'Ex: Autorisation spéciale du comité exécutif...', 'Ex: Special authorization issued by executive committee...') }}"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                <button wire:click="$set('showOverrideModal', false)" type="button" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                    {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                </button>
                <button wire:click="executeOverride" type="button" class="px-5 py-2 rounded-xl bg-amber-600 text-white font-black text-xs shadow-md">
                    {{ $t('منح التجاوز الآن', 'Accorder Dérogation', 'Execute Override Now') }}
                </button>
            </div>
        </div>
    </div>
    @endif

</div>