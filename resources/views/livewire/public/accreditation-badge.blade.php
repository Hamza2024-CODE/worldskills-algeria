<div class="min-h-screen py-10 px-4 flex flex-col items-center justify-center bg-white font-sans print:bg-white print:py-0 print:px-0">
    
    {{-- html2canvas for High-Res Image Export --}}
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    {{-- Absolute Single-Page PVC Badge Print CSS Engine --}}
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@700;800;900&display=swap');

    @media print {
        @page {
            size: portrait;
            margin: 0 !important;
        }
        html, body {
            width: 100vw !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            overflow: hidden !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body * {
            visibility: hidden !important;
        }
        nav, header, footer, .print\:hidden {
            display: none !important;
            visibility: hidden !important;
        }
        .print-badge-container, .print-badge-container * {
            visibility: visible !important;
        }
        .print-badge-container {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            box-shadow: none !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    }

    /* Mobile Responsiveness for small phone screens */
    @media (max-width: 420px) {
        .card-body-3d {
            width: 320px !important;
            min-height: 590px !important;
            padding: 16px 14px 24px 14px !important;
            border-radius: 32px !important;
        }
    }

    /* 3D Deep Physics Styles */
    .card-body-3d {
        width: 380px;
        min-height: 650px;
        border-radius: 40px;
        position: relative;
        background: var(--theme-card-bg, linear-gradient(145deg, #3B225C 0%, #221235 100%));
        box-shadow: 
            20px 30px 50px -10px rgba(0, 0, 0, 0.6),
            0px 15px 30px rgba(0, 0, 0, 0.4),
            inset 6px 6px 12px rgba(255, 255, 255, 0.2),
            inset -6px -6px 15px rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 22px 20px 30px 20px;
        z-index: 10;
        transform: rotateX(2deg) rotateY(-2deg);
        transform-style: preserve-3d;
        transition: transform 0.3s ease;
    }
    .card-body-3d:hover {
        transform: rotateX(0deg) rotateY(0deg) scale(1.02);
    }
    .lanyard-hole-3d {
        width: 70px;
        height: 18px;
        background: radial-gradient(circle at center, #ffffff 0%, #e0e6ed 100%);
        border-radius: 12px;
        margin-top: 5px;
        position: relative;
        z-index: 20;
        box-shadow: 
            inset 0 8px 10px rgba(0,0,0,0.7),
            inset 0 -2px 5px rgba(255,255,255,0.4),
            0 2px 3px rgba(255,255,255,0.2);
    }
    .lanyard-hole-3d::before {
        content: '';
        position: absolute;
        top: -4px; left: -4px; right: -4px; bottom: -4px;
        border-radius: 16px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%);
        z-index: -1;
        box-shadow: 0 4px 6px rgba(0,0,0,0.5), inset 1px 1px 2px rgba(255,255,255,0.9);
    }
    /* Soft Glow & Embroidered Fabric Stitch Effect */
    .text-embroidered-white {
        color: #FFFFFF;
        font-family: 'Cairo', system-ui, -apple-system, sans-serif !important;
        text-shadow: 
            0px 2px 4px rgba(0,0,0,0.9),
            0px 1px 2px rgba(0,0,0,0.7);
        letter-spacing: 0.02em;
        line-height: 1.4 !important;
        padding-top: 4px;
        padding-bottom: 4px;
    }
    .text-embroidered-accent {
        color: var(--theme-text-accent, #87CEEB);
        font-family: system-ui, -apple-system, sans-serif;
        text-shadow: 0px 1.5px 2px rgba(0,0,0,0.9);
        letter-spacing: 0.04em;
        line-height: 1.3 !important;
    }
    .divider-stitched-line {
        width: 100%;
        height: 0px;
        border-top: 1.5px dashed var(--theme-text-accent, rgba(255,255,255,0.45));
        margin: 4px 0;
        opacity: 0.85;
    }
    </style>

    @php
        $u = auth()->user();
        $badgeBackRoute = route('home');
        if ($u) {
            $badgeBackRoute = match($u->roles->first()?->name ?? '') {
                'SUPER_ADMIN', 'NATIONAL_ADMIN' => route('admin.dashboard'),
                'EXECUTIVE_VIEWER'              => route('executive.dashboard'),
                'COUNTRY_ADMIN'                 => route('country.dashboard'),
                'ORGANIZATION_ADMIN'            => route('organization.dashboard'),
                'JUDGE', 'EXPERT'               => route('judge.dashboard'),
                'PARTICIPANT'                   => route('participant.dashboard'),
                'MEDIA_MANAGER'                 => route('admin.media.dashboard'),
                default                         => route('profile'),
            };
        }
    @endphp

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="w-full max-w-xl mb-8 flex flex-wrap items-center justify-between gap-3 text-slate-900 print:hidden bg-white border border-slate-200 p-4 rounded-2xl shadow-xl">
        <a href="{{ $badgeBackRoute }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-slate-800 transition flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4 text-[#06205C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Retour' : (app()->getLocale() === 'en' ? 'Back' : 'الرجوع') }}</span>
        </a>
        
        <div class="flex items-center gap-2">
            <!-- Download Image PNG Button -->
            <button type="button" onclick="downloadBadgeAsImage()" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition flex items-center gap-2 border border-emerald-500">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Télécharger Image (PNG)' : (app()->getLocale() === 'en' ? 'Download Image (HD)' : 'تحميل الشارة كصورة HD 🖼️') }}</span>
            </button>

            <!-- Print PVC Button -->
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#06205C] to-[#0A3580] hover:from-[#041640] hover:to-[#06205C] text-amber-300 font-black text-xs shadow-lg shadow-[#06205C]/20 transition flex items-center gap-2 border border-amber-400/40">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Imprimer PVC' : (app()->getLocale() === 'en' ? 'Print PVC Badge' : 'طباعة الشارة الرسمية 🖨️') }}</span>
            </button>
        </div>
    </div>

    @php
        $roleKey = strtoupper($roleTitle);
        $theme = match($roleKey) {
            'SPEAKER' => [
                'card_bg' => 'radial-gradient(circle at 20% 20%, #7C3AED 0%, #4C1D95 40%, #1E1B4B 70%, #D97706 100%)',
                'edge_color' => '#1A032A',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#E9D5FF',
                'divider_glow' => '#C084FC',
                'badge' => 'محاضر رئيسي — SPEAKER',
            ],
            'MINISTERIAL EXECUTIVE OBSERVER', 'MINISTERIAL_OBSERVER' => [
                'card_bg' => 'radial-gradient(circle at 20% 20%, #7C3AED 0%, #4C1D95 40%, #1E1B4B 70%, #D97706 100%)',
                'edge_color' => '#0A0328',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#FFD700',
                'divider_glow' => '#FFC107',
                'badge' => 'وزير / مراقب تنفيذي — MINISTERIAL EXECUTIVE OBSERVER',
            ],
            'DELEGATION HEAD', 'DELEGATION_HEAD', 'VIP', 'VIP DIPLOMATIC' => [
                'card_bg' => 'radial-gradient(circle at 80% 20%, #059669 0%, #047857 35%, #022C22 75%, #B45309 100%)',
                'edge_color' => '#011C13',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#F3E5AB',
                'divider_glow' => '#D4AF37',
                'badge' => 'مسؤول الوفد — DELEGATION HEAD',
            ],
            'EXPERT JUDGE' => [
                'card_bg' => 'radial-gradient(circle at 50% 20%, #4338CA 0%, #312E81 40%, #0F172A 80%, #6D28D9 100%)',
                'edge_color' => '#0A0F1D',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#87CEEB',
                'divider_glow' => '#4FC3F7',
                'badge' => 'خبير محكّم — EXPERT JUDGE',
            ],
            'MEDIA' => [
                'card_bg' => 'radial-gradient(circle at 30% 70%, #D97706 0%, #B45309 40%, #451A03 80%, #78350F 100%)',
                'edge_color' => '#2B1003',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#FDE68A',
                'divider_glow' => '#F59E0B',
                'badge' => 'وفد إعلامي — MEDIA / PRESS',
            ],
            'ORGANIZER' => [
                'card_bg' => 'linear-gradient(135deg, #0A192F 0%, #06205C 35%, #0B48A8 70%, #0284C7 100%)',
                'edge_color' => '#090D16',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#38BDF8',
                'divider_glow' => '#0284C7',
                'badge' => 'منظم رئيسي — ORGANIZER',
            ],
            'VOLUNTEER' => [
                'card_bg' => 'linear-gradient(135deg, #134E4A 0%, #032624 100%)',
                'edge_color' => '#021F1D',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#99F6E4',
                'divider_glow' => '#2DD4BF',
                'badge' => 'متطوع — VOLUNTEER',
            ],
            default => [
                'card_bg' => 'linear-gradient(135deg, #042F2E 0%, #0D9488 40%, #0284C7 80%, #0369A1 100%)',
                'edge_color' => '#020A24',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#5EEAD4',
                'divider_glow' => '#38BDF8',
                'badge' => 'متنافس رسمي — COMPETITOR',
            ],
        };

        $verifyUrl = route('verify', ['token' => $token]);
        $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 350);
        $nameAr = $registration?->participant?->first_name_ar ? ($registration->participant->first_name_ar . ' ' . $registration->participant->last_name_ar) : ($user?->name ?? $badge?->user?->name ?? 'عضو معتمد');
        $nameLatin = $registration?->participant?->first_name_latin ? ($registration->participant->first_name_latin . ' ' . $registration->participant->last_name_latin) : ($user?->email ?? 'Accredited Member');
    @endphp

    <!-- REALISTIC 3D LANYARD FABRIC STRAP & METALLIC CLIP -->
    <div class="relative flex flex-col items-center z-50 -mb-10 print:hidden pointer-events-none">
        <img src="/lanyard-strap.png" alt="Official Lanyard Strap & Swivel Clip" class="w-72 sm:w-80 h-auto object-contain drop-shadow-[0_25px_40px_rgba(0,0,0,0.85)] translate-x-12 sm:translate-x-14 translate-y-3.5 sm:translate-y-4">
    </div>

    <!-- DYNAMIC ROLE-BASED 3D DEEP PHYSICAL BADGE -->
    <div class="print-badge-container card-body-3d" style="--theme-card-bg: {{ $theme['card_bg'] }}; --theme-text-accent: {{ $theme['text_accent'] }}; --theme-edge-color: {{ $theme['edge_color'] }}; --theme-rim-grad: {{ $theme['rim_grad'] }};">
        
        <!-- Deep Lanyard Cutout -->
        <div class="lanyard-hole-3d">
            <div style="position: absolute; top:-4px; left:-4px; right:-4px; bottom:-4px; border-radius:16px; background: var(--theme-rim-grad); z-index:-1; box-shadow: 0 4px 6px rgba(0,0,0,0.5), inset 1px 1px 2px rgba(255,255,255,0.8);"></div>
        </div>

        <div class="relative z-20 w-full flex flex-col flex-grow justify-between mt-2 overflow-hidden">
            
            <!-- Top Section: Perfectly Centered & Engraved Ministry Logo -->
            <div class="w-full flex justify-center items-center pt-5 pb-2 px-4 text-center mt-1">
                <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-10 sm:h-11 w-auto max-w-[85%] object-contain mx-auto" style="filter: brightness(0) invert(1) drop-shadow(0px -1px 1px rgba(255,255,255,0.75)) drop-shadow(0px 3px 5px rgba(0,0,0,0.92));">
            </div>

            <!-- Center: Engraved Glassmorphism QR Plate -->
            <div class="w-full flex justify-center items-center my-2 z-30">
                <div class="relative w-[220px] sm:w-[250px] h-[220px] sm:h-[250px] bg-white/20 backdrop-blur-xl rounded-[2rem] p-3 sm:p-4 flex flex-col items-center justify-between border-2 border-white/40 shadow-[0_15px_35px_rgba(0,0,0,0.5),inset_0_1px_2px_rgba(255,255,255,0.6)] max-w-[92%]">
                    <div class="w-[160px] sm:w-[190px] h-[160px] sm:h-[190px] flex items-center justify-center p-2 bg-white rounded-2xl shadow-inner border border-slate-100">
                        <img src="{{ $qrCodeUrl }}" alt="Encrypted QR Code" class="w-full h-full object-contain">
                    </div>
                    <div class="text-[8px] font-mono font-black text-white/90 uppercase tracking-widest text-center drop-shadow-xs">SECURED BY WSAP ZERO-TRUST</div>
                </div>
            </div>

            <!-- Bottom Details Section -->
            <div class="flex items-center justify-between w-full px-3 mt-1 gap-3">
                
                <!-- Name Right -->
                <div class="text-right flex-1 min-w-0 flex flex-col justify-center py-1">
                    <h2 class="text-embroidered-white text-[19px] sm:text-[21px] font-black mb-0.5 leading-normal tracking-wide text-right whitespace-nowrap overflow-visible">{{ $nameAr }}</h2>
                    <div class="divider-stitched-line"></div>
                    <div class="text-embroidered-accent text-[9.5px] font-sans uppercase tracking-wider font-bold text-right truncate" dir="ltr">{{ $nameLatin }}</div>
                </div>

                <!-- WorldSkills Logo Image -->
                <div class="flex items-center justify-center shrink-0" dir="ltr">
                    <img src="/logo.svg" alt="WorldSkills Logo" class="h-12 sm:h-13 w-auto object-contain filter brightness-0 invert drop-shadow-[0_4px_8px_rgba(0,0,0,0.85)]">
                </div>
            </div>

            <!-- Bi-Lingual Role Title Banner -->
            <div class="w-full text-center mt-2 mb-2 px-2 py-1">
                <h3 class="text-embroidered-white text-[15px] sm:text-[17px] font-bold tracking-wide uppercase text-center whitespace-nowrap overflow-visible" dir="ltr">{{ $theme['badge'] }}</h3>
            </div>

        </div>
    </div>

    <!-- JS Function to export Badge as High Resolution Image -->
    <script>
    async function makeImagePureWhite(imgEl) {
        return new Promise((resolve) => {
            try {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.onload = () => {
                    canvas.width = img.naturalWidth || img.width || 400;
                    canvas.height = img.naturalHeight || img.height || 200;
                    ctx.drawImage(img, 0, 0);
                    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const data = imgData.data;
                    for (let i = 0; i < data.length; i += 4) {
                        if (data[i + 3] > 10) {
                            data[i] = 255;
                            data[i + 1] = 255;
                            data[i + 2] = 255;
                        }
                    }
                    ctx.putImageData(imgData, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                img.onerror = () => resolve(imgEl.src);
                img.src = imgEl.src;
            } catch (e) {
                resolve(imgEl.src);
            }
        });
    }

    async function downloadBadgeAsImage() {
        const card = document.querySelector('.card-body-3d');
        if (!card) return;

        const origTransform = card.style.transform;
        const origBoxShadow = card.style.boxShadow;

        card.style.transform = 'none';
        card.style.boxShadow = 'none';

        // Pre-convert any dark logos into native pure white DataURL canvas images before html2canvas capture
        const imgs = card.querySelectorAll('img');
        const originalSrcs = [];
        for (let i = 0; i < imgs.length; i++) {
            originalSrcs[i] = imgs[i].src;
            if (imgs[i].src.includes('ministry-logo') || imgs[i].src.includes('logo.svg') || imgs[i].classList.contains('brightness-0')) {
                const whiteDataUrl = await makeImagePureWhite(imgs[i]);
                imgs[i].src = whiteDataUrl;
                imgs[i].style.filter = 'none';
            }
        }

        html2canvas(card, {
            scale: 3,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
            onclone: (clonedDoc) => {
                const clonedCard = clonedDoc.querySelector('.card-body-3d');
                if (clonedCard) {
                    clonedCard.style.transform = 'none';
                    clonedCard.style.boxShadow = 'none';
                    clonedCard.style.overflow = 'visible';
                }
                const elements = clonedDoc.querySelectorAll('h2, h3, span, div, p, .text-embroidered-white, .text-embroidered-accent');
                elements.forEach(el => {
                    el.style.letterSpacing = 'normal';
                    el.style.wordSpacing = 'normal';
                    el.style.textShadow = 'none';
                    el.style.filter = 'none';
                });
            }
        }).then(canvas => {
            // Restore original web page image sources
            for (let i = 0; i < imgs.length; i++) {
                imgs[i].src = originalSrcs[i];
                if (imgs[i].src.includes('ministry-logo') || imgs[i].src.includes('logo.svg')) {
                    imgs[i].style.filter = 'brightness(0) invert(1)';
                }
            }
            card.style.transform = origTransform;
            card.style.boxShadow = origBoxShadow;

            const link = document.createElement('a');
            link.download = 'badge-accreditation-wsap-{{ Str::slug($nameLatin ?: "official") }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }).catch(err => {
            for (let i = 0; i < imgs.length; i++) {
                imgs[i].src = originalSrcs[i];
            }
            card.style.transform = origTransform;
            card.style.boxShadow = origBoxShadow;
            console.error('Error exporting image:', err);
            alert('حدث خطأ أثناء تحميل الصورة.');
        });
    }
    </script>

</div>
