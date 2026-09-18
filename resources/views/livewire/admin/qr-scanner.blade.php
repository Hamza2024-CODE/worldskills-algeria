@php
    $locale = app()->getLocale();
    $delegationMember = $delegationMember ?? null;
    $registration = $registration ?? null;
    $scannedUser = $scannedUser ?? null;
    $scannedBadge = $scannedBadge ?? null;
    $roomAllocation = $roomAllocation ?? null;
    $accessDecision = $accessDecision ?? [];
    $showOverrideModal = $showOverrideModal ?? false;

    $t = function($ar, $fr, $en) use ($locale) {
        return match($locale) {
            'fr' => $fr,
            'en' => $en,
            default => $ar,
        };
    };

    $memberStatus = $delegationMember?->status 
        ? (is_object($delegationMember->status) ? $delegationMember->status->value : (string) $delegationMember->status)
        : null;

    $regStatus = $registration?->status 
        ? (is_object($registration->status) ? $registration->status->value : (string) $registration->status)
        : null;

    $rejectionReason = $delegationMember?->rejection_reason 
        ?: ($registration?->rejection_reason ?: ($registration?->notes ?: null));

    $isRejected = in_array(strtoupper((string) $memberStatus), ['REJECTED', 'DISQUALIFIED', 'CANCELLED', 'SUSPENDED', 'REFUSED'])
        || in_array(strtoupper((string) $regStatus), ['REJECTED', 'DISQUALIFIED', 'CANCELLED', 'SUSPENDED', 'REFUSED'])
        || (!empty($accessDecision) && !($accessDecision['is_allowed'] ?? true));

    $statusLabel = match(true) {
        $isRejected => $t('مرفوض / غير مصرح بالدخول', 'REJETÉ / NON AUTORISÉ', 'REJECTED / ACCESS DENIED'),
        strtoupper((string)$regStatus) === 'APPROVED' || strtoupper((string)$memberStatus) === 'APPROVED' => $t('معتمد ومصرح به', 'ACCRÉDITÉ & AUTORISÉ', 'APPROVED & AUTHORIZED'),
        strtoupper((string)$regStatus) === 'PENDING' || strtoupper((string)$memberStatus) === 'PENDING' => $t('قيد المراجعة', 'EN ATTENTE', 'PENDING REVIEW'),
        default => $t('نشط بالموقع', 'ACTIF', 'ACTIVE'),
    };

    $skillName = $registration?->skill?->name_ar 
        ?: ($delegationMember?->skill?->name_ar ?: ($registration?->skill?->name_fr ?? '—'));

    $countryName = $scannedUser?->country?->name_ar 
        ?: ($delegationMember?->delegation?->country?->name_ar ?: 'الجزائر');

    $orgName = $scannedUser?->organization?->name_ar ?: '—';

    $photoUrl = null;
    if ($delegationMember?->photo_path) {
        $photoUrl = asset('storage/' . $delegationMember->photo_path);
    } elseif ($scannedUser?->avatar_path) {
        $photoUrl = asset('storage/' . $scannedUser->avatar_path);
    }
@endphp

<div class="space-y-6 select-none"
     x-data="{
        cameraOpen: false,
        html5QrCode: null,
        cameraError: null,
        async ensureScriptLoaded() {
            if (typeof Html5Qrcode !== 'undefined') return true;
            return new Promise((resolve) => {
                const script = document.createElement('script');
                script.src = '/js/html5-qrcode.min.js';
                script.onload = () => resolve(true);
                script.onerror = () => {
                    console.warn('Local html5-qrcode.min.js failed to load, trying CDN fallback...');
                    const cdnScript = document.createElement('script');
                    cdnScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js';
                    cdnScript.onload = () => resolve(true);
                    cdnScript.onerror = () => resolve(false);
                    document.head.appendChild(cdnScript);
                };
                document.head.appendChild(script);
            });
        },
        async toggleCamera() {
            if (this.cameraOpen) {
                await this.stopCamera();
            } else {
                await this.startCamera();
            }
        },
        async startCamera() {
            this.cameraError = null;
            this.cameraOpen = true;

            await this.ensureScriptLoaded();
            await this.$nextTick();

            if (typeof Html5Qrcode === 'undefined') {
                this.cameraError = 'لم يتم تحميل مكتبة الكاميرا بنجاح. يرجى إعادة تحديث الصفحة.';
                return;
            }

            try {
                if (this.html5QrCode) {
                    try { await this.html5QrCode.stop(); } catch(e){}
                    try { await this.html5QrCode.clear(); } catch(e){}
                }

                this.html5QrCode = new Html5Qrcode('qr-reader-video-container');

                const config = {
                    fps: 15,
                    qrbox: (viewfinderWidth, viewfinderHeight) => {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const qrboxSize = Math.floor(minEdge * 0.75);
                        return { width: qrboxSize, height: qrboxSize };
                    },
                    aspectRatio: 1.0
                };

                const onScanSuccess = (decodedText) => {
                    try {
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.type = 'sine';
                        osc.frequency.value = 880;
                        gain.gain.value = 0.1;
                        osc.start();
                        osc.stop(ctx.currentTime + 0.15);
                    } catch(e) {}

                    @this.set('query', decodedText);
                    @this.scan();
                    this.stopCamera();
                };

                const onScanFailure = (error) => {
                    // Ignore per-frame decode failure
                };

                try {
                    await this.html5QrCode.start(
                        { facingMode: 'environment' },
                        config,
                        onScanSuccess,
                        onScanFailure
                    );
                } catch (envErr) {
                    console.warn('Environment camera failed, trying device list fallback:', envErr);
                    const devices = await Html5Qrcode.getCameras();
                    if (devices && devices.length > 0) {
                        const backCam = devices.find(d => d.label.toLowerCase().includes('back') || d.label.toLowerCase().includes('rear') || d.label.toLowerCase().includes('خلف'));
                        const cameraId = backCam ? backCam.id : devices[0].id;
                        await this.html5QrCode.start(
                            cameraId,
                            config,
                            onScanSuccess,
                            onScanFailure
                        );
                    } else {
                        throw envErr;
                    }
                }
            } catch (err) {
                console.error('Camera init error:', err);
                let msg = err.message || err;
                if (typeof msg === 'string') {
                    if (msg.includes('Permission') || msg.includes('NotAllowedError')) {
                        msg = 'يرجى السماح باستخدام الكاميرا في إعدادات المتصفح وإعادة المحاولة.';
                    } else if (msg.includes('NotFoundError') || msg.includes('DevicesNotFoundError')) {
                        msg = 'لم يتم العثور على أي كاميرا متصلة بالجهاز.';
                    } else if (msg.includes('NotReadableError') || msg.includes('TrackStartError')) {
                        msg = 'الكاميرا مستخدمة حالياً من قبل تطبيق آخر أو متصفح آخر.';
                    }
                }
                this.cameraError = 'تعذر تشغيل الكاميرا: ' + msg;
            }
        },
        async stopCamera() {
            if (this.html5QrCode) {
                try {
                    await this.html5QrCode.stop();
                    await this.html5QrCode.clear();
                } catch(e) {}
                this.html5QrCode = null;
            }
            this.cameraOpen = false;
        }
     }">

    {{-- Script dependency --}}
    <script src="/js/html5-qrcode.min.js"></script>

    {{-- TOP TITLE HEADER CAPSULE --}}
    <div class="bg-gradient-to-r from-[#06205C] via-[#0A3580] to-[#0052CC] rounded-3xl p-6 text-white shadow-xl border border-white/10 relative overflow-hidden">
        <div class="absolute -end-10 -bottom-10 w-48 h-48 bg-blue-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-blue-200 backdrop-blur-md">
                    <svg class="w-4 h-4 text-emerald-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>{{ $t('الماسح الضوئي المباشر للشارات والأكواد', 'Scanner QR Sécurité Direct', 'Live Security QR Scanner') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    {{ $t('التحقق الأمني واعتمادات الشارات', 'Contrôle d Accès & Badging', 'Security & Accreditation Check') }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 font-medium">
                    {{ $t('امسح كود الـ QR الخاص بالشارة للحصول فوراً على الملف الكامل والتحقق من الصلاحيات.', 'Scannez le code QR du badge pour consulter le dossier complet et vérifier les accès.', 'Scan badge QR code for instant full profile dossier and security access verification.') }}
                </p>
            </div>

            {{-- SEARCH FORM & CAMERA TOGGLE --}}
            <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                <button type="button" @click="toggleCamera()"
                    class="px-5 py-3 rounded-2xl text-white font-black text-xs transition backdrop-blur-md flex items-center justify-center gap-2.5 shadow-md"
                    :class="cameraOpen ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-500 hover:bg-emerald-600'">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574v9.176c0 1.067.75 1.994 1.802 2.169a47.865 47.865 0 0011.396 0c1.052-.175 1.802-1.102 1.802-2.169V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0c-.69.04-1.332.42-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                    <span x-text="cameraOpen ? '{{ $t('إغلاق الكاميرا', 'Fermer Caméra', 'Close Camera') }}' : '{{ $t('تشغيل الكاميرا والمثال المباشر', 'Ouvrir Caméra QR', 'Open Camera Scanner') }}'"></span>
                </button>
            </div>
        </div>

        {{-- CAMERA FEED CONTAINER --}}
        <div x-show="cameraOpen" x-transition class="mt-4 pt-4 border-t border-white/10 space-y-3">
            <div class="relative w-full max-w-md mx-auto aspect-square rounded-3xl overflow-hidden border-2 border-emerald-400/80 shadow-2xl bg-slate-950">
                <div id="qr-reader-video-container" class="w-full h-full object-cover"></div>

                <div x-show="cameraError" class="absolute inset-0 p-4 bg-slate-900/90 flex flex-col items-center justify-center text-center text-rose-300 space-y-2">
                    <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    <p class="text-xs font-bold" x-text="cameraError"></p>
                </div>
            </div>
        </div>

        {{-- MANUAL INPUT FORM --}}
        <form wire:submit.prevent="scan" class="mt-5">
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <input type="text" wire:model.defer="query" autofocus id="badge-input"
                        placeholder="{{ $t('أدخل UUID الشارة، التوكين، رقم جواز السفر، الإيميل أو معرف المستخدم...', 'Saisissez le code UUID, passeport, email ou ID...', 'Enter Badge UUID, Token, Passport, Email or User ID...') }}"
                        class="w-full pe-4 ps-11 py-3.5 rounded-2xl border border-white/20 text-sm font-bold bg-white/10 text-white placeholder-blue-200 focus:bg-white focus:text-slate-900 transition shadow-inner">
                    <svg class="w-5 h-5 text-blue-200 absolute start-4 top-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <button type="submit" class="px-6 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs transition shadow-lg shrink-0 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>{{ $t('فحص وتفكيك الـ QR', 'Vérifier & Analyser', 'Scan & Verify') }}</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ACCESS DECISION RESULT CARD --}}
    @if(!empty($accessDecision))
    <div class="p-6 rounded-3xl border shadow-xl space-y-4 transition-all duration-300 {{ ($accessDecision['is_allowed'] ?? false) ? 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-300 dark:border-emerald-700 text-emerald-950 dark:text-emerald-100' : 'bg-rose-50 dark:bg-rose-950/40 border-rose-300 dark:border-rose-700 text-rose-950 dark:text-rose-100' }}">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-black text-xl shrink-0 shadow-md {{ ($accessDecision['is_allowed'] ?? false) ? 'bg-emerald-600' : 'bg-rose-600' }}">
                    @if($accessDecision['is_allowed'] ?? false)
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    @endif
                </div>
                <div class="space-y-1">
                    <h2 class="text-lg sm:text-xl font-black tracking-tight">
                        @if($accessDecision['is_allowed'] ?? false)
                            {{ $t('إذن وصول مقبول ومصرح به 100%', 'Accès Autorisé & Accrédité 100%', 'Access Granted & Authorized 100%') }}
                        @else
                            {{ $t('🛑 تنبيه أمني: وصول مرفوض ومحظور في المنظومة!', '🛑 Accès Refusé & Interdit dans le Système !', '🛑 Security Alert: Access Denied & Prohibited!') }}
                        @endif
                    </h2>
                    <p class="text-xs sm:text-sm font-bold opacity-90 leading-relaxed">
                        {{ $accessDecision['message_ar'] ?? '' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-center shrink-0">
                <span class="px-3.5 py-1.5 rounded-full text-xs font-black font-mono border shadow-2xs {{ ($accessDecision['is_allowed'] ?? false) ? 'bg-emerald-100 dark:bg-emerald-900/60 border-emerald-400 text-emerald-900 dark:text-emerald-200' : 'bg-rose-100 dark:bg-rose-900/60 border-rose-400 text-rose-900 dark:text-rose-200' }}">
                    CODE: {{ $accessDecision['reason_code'] ?? 'UNKNOWN' }}
                </span>
            </div>
        </div>

        @if(!($accessDecision['is_allowed'] ?? false))
        <div class="pt-3 border-t border-rose-200/60 dark:border-rose-800/60 flex items-center justify-between gap-4">
            <span class="text-xs font-bold text-rose-800 dark:text-rose-300 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ $t('ملاحظة أمنية: يمنع دخول حامل هذه الشارة لمناطق الفعالية حتى تسوية الوضعية', 'Entrée interdite jusqu à régularisation du dossier.', 'Security Note: Entry prohibited until file is regularized.') }}
            </span>
            <button wire:click="$set('showOverrideModal', true)" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md shrink-0">
                {{ $t('تجاوز طارئ (Super Admin Override)', 'Dérogation (Super Admin)', 'Super Admin Override') }}
            </button>
        </div>
        @endif
    </div>
    @endif

    {{-- ACCREDITED USER FULL DOSSIER SHEET --}}
    @if($scannedUser)
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-2xl overflow-hidden space-y-0">

        {{-- TOP PROFILE HEADER BAND --}}
        <div class="bg-gradient-to-l from-[#041235] via-[#06205C] to-[#0B1120] p-6 text-white relative overflow-hidden">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                
                {{-- AVATAR & IDENTITY --}}
                <div class="flex items-center gap-5">
                    <div class="w-24 h-24 rounded-2xl border-2 border-white/30 overflow-hidden shrink-0 shadow-2xl bg-slate-900 flex items-center justify-center relative">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $scannedUser->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-900 to-slate-900 text-white p-2 text-center">
                                <svg class="w-10 h-10 text-blue-300/80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span class="text-[10px] font-black text-blue-200 uppercase tracking-wider">
                                    {{ mb_substr($delegationMember?->first_name ?: $scannedUser->name, 0, 1) }}
                                </span>
                            </div>
                        @endif

                        @if($isRejected)
                            <span class="absolute -bottom-1 -end-1 bg-rose-600 text-white rounded-full p-1 border-2 border-slate-900 shadow-md" title="مرفوض">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            </span>
                        @endif
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                                {{ $delegationMember?->first_name ? ($delegationMember->first_name . ' ' . $delegationMember->last_name) : $scannedUser->name }}
                            </h3>
                            @if($scannedUser->country?->flag_emoji)
                                <span class="text-xl" title="{{ $countryName }}">{{ $scannedUser->country->flag_emoji }}</span>
                            @endif
                        </div>

                        <p class="text-blue-200 text-xs font-mono font-medium dir-ltr text-start">
                            {{ $scannedUser->email }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            {{-- Role Badge --}}
                            @php 
                                $role = $delegationMember?->member_type 
                                    ?: ($scannedUser->roles->first()?->name ?: 'COMPETITOR');
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-400 text-slate-950 border border-amber-300 uppercase shadow-2xs">
                                {{ $role }}
                            </span>

                            {{-- Status Badge --}}
                            @if($isRejected)
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-600 text-white border border-rose-500 shadow-2xs flex items-center gap-1.5 animate-pulse">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                    <span>{{ $statusLabel }}</span>
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-500 text-white border border-emerald-400 shadow-2xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $statusLabel }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- QUICK BADGE UUID TOKEN --}}
                <div class="bg-white/10 dark:bg-slate-900/60 p-3.5 rounded-2xl border border-white/15 backdrop-blur-md text-start sm:text-end space-y-1 self-stretch sm:self-auto shrink-0">
                    <span class="text-[10px] uppercase tracking-wider font-black text-blue-200 block">
                        {{ $t('معرف الشارة الرقمية (Badge UUID)', 'UUID du Badge', 'Badge UUID') }}
                    </span>
                    <span class="text-xs font-black font-mono text-amber-300 block">
                        {{ $scannedBadge?->badge_uuid ?: ($scannedUser->uuid ?: '—') }}
                    </span>
                    <span class="text-[10px] text-slate-300 block">
                        {{ $t('تاريخ الإصدار: ', 'Émis le: ', 'Issued: ') }}{{ $scannedBadge?->created_at?->format('Y/m/d') ?: ($scannedUser->created_at?->format('Y/m/d') ?: '—') }}
                    </span>
                </div>

            </div>

            {{-- REJECTION REASON CALLOUT BOX --}}
            @if($isRejected && $rejectionReason)
            <div class="mt-5 p-4 rounded-2xl bg-rose-600/90 border border-rose-400 text-white space-y-1 shadow-lg">
                <div class="flex items-center gap-2 font-black text-sm">
                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <span>{{ $t('سبب رفض الاعتماد والتسجيل الرسمي:', 'Motif du Rejet Officiel :', 'Official Rejection Reason:') }}</span>
                </div>
                <p class="text-xs font-bold leading-relaxed ps-7 text-rose-100">
                    {{ $rejectionReason }}
                </p>
            </div>
            @endif

        </div>

        {{-- DOSSIER DETAILS GRID (8 COMPREHENSIVE CARDS) --}}
        <div class="p-6 bg-slate-50/50 dark:bg-slate-900/40 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- CARD 1: SKILL & CATEGORY --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-[#0052CC] dark:text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        <span>{{ $t('المهنة / التخصص الفني', 'Métier / Spécialité', 'Skill & Trade Domain') }}</span>
                    </div>
                    <span class="text-sm font-black text-slate-900 dark:text-white block leading-tight">
                        {{ $skillName }}
                    </span>
                    @if($registration?->registration_number)
                        <span class="text-[11px] font-mono font-bold text-slate-500 dark:text-slate-400 block pt-1">
                            #{{ $registration->registration_number }}
                        </span>
                    @endif
                </div>

                {{-- CARD 2: COUNTRY & ORGANIZATION --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-[#0052CC] dark:text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m-18.432 0A8.959 8.959 0 013 12c0-.778.099-1.533.284-2.253"/>
                        </svg>
                        <span>{{ $t('الدولة والمؤسسة التكوينية', 'Pays & Établissement', 'Country & Institution') }}</span>
                    </div>
                    <span class="text-sm font-black text-slate-900 dark:text-white block leading-tight">
                        {{ $countryName }}
                    </span>
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block truncate pt-0.5">
                        {{ $orgName }}
                    </span>
                </div>

                {{-- CARD 3: PASSPORT & NIN --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-[#0052CC] dark:text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                        </svg>
                        <span>{{ $t('وثائق الهوية الوطنية', 'Pièces d Identité', 'Identity Documents') }}</span>
                    </div>
                    <div class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200 space-y-0.5">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-sans">{{ $t('جواز السفر:', 'Passeport:', 'Passport:') }}</span>
                            <span>{{ $delegationMember?->passport_number ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-sans">{{ $t('الرقم الوطني NIN:', 'NIN:', 'NIN:') }}</span>
                            <span>{{ $delegationMember?->nin_number ?: '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: ACCOMMODATION & ROOM --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-[#0052CC] dark:text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                        <span>{{ $t('مقر الإقامة والغرفة', 'Hébergement & Chambre', 'Accommodation & Room') }}</span>
                    </div>
                    <span class="text-xs font-black text-slate-900 dark:text-white block truncate">
                        {{ $roomAllocation?->room?->accommodation?->name_ar ?: 'القرية الأورومتوسطية (لم تحدد بعد)' }}
                    </span>
                    <span class="text-[11px] font-mono font-bold text-[#0052CC] dark:text-blue-400 block pt-0.5">
                        {{ $t('غرفة رقم: ', 'Chambre N°: ', 'Room #: ') }}{{ $roomAllocation?->room?->room_number ?: '—' }}
                    </span>
                </div>

                {{-- CARD 5: DIETARY NOTES --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25"/>
                        </svg>
                        <span>{{ $t('بيانات الإطعام والحمية', 'Régime Alimentaire', 'Dietary Requirements') }}</span>
                    </div>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">
                        {{ !empty($delegationMember?->dietary_requirements) ? implode(', ', $delegationMember->dietary_requirements) : 'حلال / عالي التغذية' }}
                    </span>
                    @if($delegationMember?->dietary_notes)
                        <span class="text-[11px] text-slate-500 block truncate pt-0.5">
                            {{ $delegationMember->dietary_notes }}
                        </span>
                    @endif
                </div>

                {{-- CARD 6: PERSONAL SPECS & SIZES --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-purple-600 dark:text-purple-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        <span>{{ $t('القياسات الشخصية', 'Taille & Pointure', 'Personal Specs') }}</span>
                    </div>
                    <div class="text-xs font-bold text-slate-800 dark:text-slate-200 space-y-0.5">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-sans">{{ $t('الجنس:', 'Genre:', 'Gender:') }}</span>
                            <span>{{ $delegationMember?->gender === 'MALE' ? 'ذكر' : ($delegationMember?->gender === 'FEMALE' ? 'أنثى' : '—') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-sans">{{ $t('بدلة | حذاء:', 'Taille | Pointure:', 'Suit | Shoe:') }}</span>
                            <span>{{ $delegationMember?->suit_size ?: ($registration?->suit_size ?: '—') }} | {{ $delegationMember?->shoe_size ?: ($registration?->shoe_size ?: '—') }}</span>
                        </div>
                    </div>
                </div>

                {{-- CARD 7: FLIGHTS & TRAVEL --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-amber-600 dark:text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3 21l9-3 9 3-3-9M6 12l9-3m-9 3l-3-9 9 3 9-3-3 9"/>
                        </svg>
                        <span>{{ $t('رحلات الوصول والمغادرة', 'Vols & Logistique', 'Flights & Travel') }}</span>
                    </div>
                    <div class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200 space-y-0.5">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-sans">{{ $t('الوصول:', 'Arrivée:', 'Arrival:') }}</span>
                            <span>{{ $delegationMember?->arrival_flight ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-sans">{{ $t('المغادرة:', 'Départ:', 'Departure:') }}</span>
                            <span>{{ $delegationMember?->departure_flight ?: '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- CARD 8: SYSTEM & ACCESS METADATA --}}
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 shadow-2xs space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-black text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0h-18"/>
                        </svg>
                        <span>{{ $t('معلومات النظام والنفاذ', 'Infos Système', 'System Info') }}</span>
                    </div>
                    <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200 block">
                        ID: #{{ $scannedUser->id }}
                    </span>
                    <span class="text-[11px] text-slate-500 block truncate">
                        {{ $t('آخر فحص: ', 'Dernier contrôle: ', 'Last Scan: ') }}{{ now()->format('H:i:s Y/m/d') }}
                    </span>
                </div>

            </div>

            {{-- SECURITY ZONE PERMISSIONS GRID --}}
            @if(!empty($zonePermissions))
            <div class="border-t border-slate-200 dark:border-slate-700 pt-5 space-y-3">
                <h4 class="text-sm font-black text-[#041235] dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>{{ $t('تصاريح الدخول للمناطق والقطاعات الأمنية للموقع', 'Accès aux Zones Sécurisées du Site', 'Security Zone Clearances') }}</span>
                </h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    @foreach($zonePermissions as $zp)
                    @php
                        $isAllow = ($zp['permission'] ?? '') === 'ALLOW' && !$isRejected;
                        $zoneName = $locale === 'fr' ? ($zp['zone']['name_fr'] ?? $zp['zone']['name_ar'] ?? $zp['zone']['name'] ?? '') : ($locale === 'en' ? ($zp['zone']['name_en'] ?? $zp['zone']['name_ar'] ?? $zp['zone']['name'] ?? '') : ($zp['zone']['name_ar'] ?? $zp['zone']['name'] ?? ''));
                    @endphp
                    <div class="px-3.5 py-2.5 rounded-2xl border text-xs font-bold flex items-center gap-2.5 transition shadow-2xs
                        {{ $isAllow ? 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-200' : 'bg-rose-50 dark:bg-rose-950/40 border-rose-300 dark:border-rose-700 text-rose-900 dark:text-rose-200' }}">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-white shrink-0 {{ $isAllow ? 'bg-emerald-600' : 'bg-rose-600' }}">
                            @if($isAllow)
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            @endif
                        </div>
                        <div class="truncate">
                            <span class="block truncate font-black">{{ $zoneName }}</span>
                            <span class="text-[10px] opacity-75 uppercase font-mono">{{ $isAllow ? 'مسموح' : 'محظور' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- FOOTER --}}
        <div class="bg-slate-100 dark:bg-slate-900 px-6 py-3 border-t border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span class="text-xs text-slate-500 font-mono truncate">
                TOKEN: {{ $scannedBadge?->access_token ?? 'WSAP-TOKEN-VALIDATED' }}
            </span>
            <span class="text-xs font-black text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                {{ $t('تم الفحص المباشر في المنظومة — ', 'Contrôle Validé — ', 'Security Verified — ') }}{{ now()->format('d/m/Y H:i:s') }}
            </span>
        </div>

    </div>
    @endif

    {{-- SUPER ADMIN OVERRIDE MODAL --}}
    @if($showOverrideModal)
    <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <h3 class="text-base font-black text-amber-700 dark:text-amber-400">
                    {{ $t('تأكيد التجاوز الطارئ من مدير النظام', 'Dérogation Exceptionnelle Super Admin', 'Confirm Super Admin Emergency Override') }}
                </h3>
                <button wire:click="$set('showOverrideModal', false)" class="text-slate-400 hover:text-slate-600"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
            </div>

            <div class="space-y-3 text-xs">
                <p class="text-slate-600 dark:text-slate-300 font-bold leading-relaxed">
                    {{ $t('أنت على وشك منح تجاوز استثنائي لهذه الشارة. يرجى إدخال السبب الإلزامي لتسجيله في سجلات التدقيق الأمني.', 'Vous êtes sur le point d accorder une dérogation exceptionnelle. Veuillez indiquer le motif obligatoire.', 'You are about to issue an emergency override. Please enter mandatory reason for audit log.') }}
                </p>
                <div>
                    <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
                        {{ $t('السبب الإلزامي للتجاوز *', 'Motif obligatoire *', 'Mandatory Reason *') }}
                    </label>
                    <textarea wire:model="overrideReasonAr" required rows="3"
                        placeholder="{{ $t('مثال: إذن خاص صادر من اللجنة التنفيذية للاجتماع الطارئ...', 'Ex: Autorisation spéciale du comité exécutif...', 'Ex: Special authorization issued by executive committee...') }}"
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 font-bold text-xs"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                <button wire:click="$set('showOverrideModal', false)" type="button" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">
                    {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                </button>
                <button wire:click="executeOverride" type="button" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md">
                    {{ $t('منح التجاوز الآن', 'Accorder Dérogation', 'Execute Override Now') }}
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
