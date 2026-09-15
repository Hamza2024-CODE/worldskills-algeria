<div class="py-8 sm:py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 font-sans">
    
    <!-- HEADER -->
    <div class="text-center space-y-3">
        
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-ws-navy tracking-tight">{{ app()->getLocale() === "fr" ? "Vérification & Cryptage des Badges d'Accréditation" : (app()->getLocale() === 'en' ? 'Accreditation Badge Verification System' : 'نظام التثبت والتشفير الإلكتروني لشارات الاعتماد') }}</h1>
        <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-lg mx-auto leading-relaxed">
            {{ app()->getLocale() === 'fr' ? 'Cryptage haute sécurité Zero-Trust garantissant la protection contre la falsification.' : (app()->getLocale() === 'en' ? 'High-security Zero-Trust encryption ensuring anti-counterfeiting.' : 'تشفير عالي الأمان بنظام Zero-Trust يضمن منع التزوير وحصر تفكيك بيانات الشارات لإدارة المنصة والأدمن فقط.') }}
        </p>
    </div>

    <!-- SEARCH BAR -->
    <div class="bg-white rounded-ws-md p-4 sm:p-6 shadow-md border border-ws-border">
        <form wire:submit.prevent="verify" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full relative">
                <input 
                    type="text" 
                    wire:model="query" 
                    placeholder="{{ app()->getLocale() === 'fr' ? 'Entrez le code badge crypté...' : (app()->getLocale() === 'en' ? 'Enter encrypted badge code...' : 'أدخل رمز الشارة المشفر أو رقم التوثيق...') }}" 
                    class="w-full ps-11 pe-4 py-3.5 rounded-ws-sm bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-ws-navy placeholder-slate-400 focus:bg-white ws-focus-ring ws-transition"
                >
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
            </div>
            <button 
                type="submit" 
                class="w-full sm:w-auto px-8 py-3.5 rounded-ws-sm bg-ws-primary hover:bg-ws-primary-hover text-white font-black text-xs shadow-md ws-transition flex items-center justify-center gap-2 shrink-0 active:scale-95 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Vérifier Badge' : (app()->getLocale() === 'en' ? 'Verify Code' : 'فحص كود الاعتماد') }}</span>
            </button>
        </form>
    </div>
    <!-- VERIFICATION RESULT -->
    @if($searched)
        @if($result)

            @if(!$isAuthorizedScanner)
                <!-- ACCESS DENIED FOR PUBLIC / EXTERNAL SCANNERS -->
                <div class="bg-white rounded-3xl p-8 border-2 border-rose-200 shadow-2xl text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto border border-rose-200">
                        <x-ws.icon name="x-circle" class="w-8 h-8 text-rose-600" />
                    </div>
                    
                    <div class="space-y-1">
                        <span class="text-xs font-mono font-bold text-rose-500 uppercase tracking-widest block">ACCESS DENIED — UNAUTHORIZED SCANNER</span>
                        <h2 class="text-xl font-black text-rose-800">ليس لديك الصلاحية لقراءة وتفكيك كود الـ QR هذا</h2>
                        <p class="text-xs text-slate-600 max-w-md mx-auto leading-relaxed pt-1">
                            عذراً، كود الـ QR هذا مشفر ومحمي بنظام أمان خاص بالمنصة. قراءة واستخراج بيانات الشخص المسجل وموقع مبيته محصورة <span class="font-bold text-rose-700">حصرياً في الماسح الداخلي للمنصة لدى الأدمن والمصرح لهم فقط</span>.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-3 text-xs">
                        <span class="text-slate-500 font-medium">إذا كنت مديراً أو من طاقم الأمن والتنظيم:</span>
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-black transition shadow-xs">
                            تسجيل الدخول كأدمن لتفكيك الشارة
                        </a>
                    </div>
                </div>
            @else
                <!-- FULL ACCREDITED DOSSIER FOR AUTHORIZED ADMIN -->
                @php
                    $p = $result->participant;
                @endphp
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-2xl space-y-8">
                    
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-100 pb-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $result->photo_url }}" alt="Photo" class="w-20 h-20 rounded-2xl object-cover border-2 border-brand-500 shadow-md shrink-0">
                            <div>
                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider">الملف الأمني المعتمد (Accredited Security Dossier)</span>
                                <h2 class="text-2xl font-black text-[#06205C]">
                                    {{ $p?->first_name_ar ?? $result->user?->name }} {{ $p?->last_name_ar }}
                                </h2>
                                <p class="text-xs font-bold text-slate-500 font-mono uppercase">
                                    {{ $p?->first_name_latin }} {{ $p?->last_name_latin }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="px-4 py-1.5 rounded-full font-black text-xs border bg-emerald-50 text-emerald-700 border-emerald-300 inline-block shadow-2xs">
                                <span class="inline-flex items-center gap-1.5"><x-ws.icon name="check-circle" class="w-4 h-4 text-emerald-600" /> اعتماد رسمي مقبول 100% (AUTHORIZED ADMIN ACCESS)</span>
                            </span>
                            <span class="text-[10px] font-mono text-slate-400 block mt-1">Code: {{ $result->registration_number }}</span>
                        </div>
                    </div>

                    <!-- 3 DOSSIER SECTIONS: PERSONAL, SKILL, ACCOMMODATION & LOGISTICS -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                        
                        <!-- 1. PERSONAL INFORMATION (المعلومات الشخصية) -->
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                                <h3 class="font-black text-[#06205C] uppercase">المعلومات الشخصية (Personal Info)</h3>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">البريد الإلكتروني / Email</span>
                                    <span class="font-mono font-bold text-slate-900 block">{{ $p?->email ?? $result->user?->email }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">رقم الهاتف / Phone</span>
                                    <span class="font-mono font-bold text-slate-900 block">{{ $p?->phone ?? '—' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">رقم الهوية الوطنية / جواز السفر</span>
                                    <span class="font-mono font-bold text-slate-900 block">{{ $p?->national_id ?? $p?->passport_number ?? '—' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. SKILL & TRADE DETAILS (معلومات التخصص والوفد) -->
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                <h3 class="font-black text-[#06205C] uppercase">معلومات التخصص والوفد (Skill Info)</h3>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">التخصص الأولمبي المسجل / Trade Skill</span>
                                    <span class="font-black text-brand-600 block">{{ $result->skill?->code }} — {{ $result->skill?->name_ar }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">دولة الوفد المشارك / Country</span>
                                    <span class="font-bold text-slate-900 block">{{ $result->country?->name_ar ?? 'الجزائر' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">المؤسسة التكوينية والولاية / Institution</span>
                                    <span class="font-bold text-slate-900 block">{{ $result->wilaya?->name_ar }} — {{ $result->organization?->name_ar ?? 'المؤسسة الوطنية المعتمدة' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. ACCOMMODATION & LOGISTICS (معلومات المبيت والإقامة واللوجستيك) -->
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <h3 class="font-black text-[#06205C] uppercase">المبيت والإقامة واللوجستيك (Accommodation)</h3>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">موقع الإقامة والمبيت / Hotel & Residence</span>
                                    <span class="font-black text-emerald-700 block">
                                        {{ $accommodation?->room?->accommodation?->name_ar ?? 'فندق وإقامة الأولمبياد الرسمية — الجزائر العاصمة' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">رقم الغرفة وجناح المبيت / Room Allocation</span>
                                    <span class="font-mono font-bold text-slate-900 block">
                                        الغرفة: {{ $accommodation?->room?->room_number ?? 'Room-104 (A-Block)' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold block text-[10px]">المقاسات والبدلة الرسمية / Sizes</span>
                                    <div class="flex items-center gap-2 mt-1 font-mono font-bold text-slate-800">
                                        <span class="bg-white px-2 py-1 rounded border">البدلة: {{ $result->suit_size ?? 'L' }}</span>
                                        <span class="bg-white px-2 py-1 rounded border">الحذاء: {{ $result->shoe_size ?? '42' }}</span>
                                        <span class="bg-white px-2 py-1 rounded border">الطول: {{ $result->height_cm ?? '175' }} سم</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @endif

        @else
            <div class="p-8 bg-rose-50 border border-rose-200 rounded-3xl text-center space-y-2">
                <div class="flex justify-center"><x-ws.icon name="exclamation-triangle" class="w-8 h-8 text-rose-500" /></div>
                <h3 class="text-base font-black text-rose-800">لم يتم العثور على أي ملف معتمد بهذا الكود</h3>
                <p class="text-xs text-rose-600">يرجى التأكد من مسح شارة رسمية معتمدة صادرة عن منصة WorldSkills Algeria.</p>
            </div>
        @endif
    @endif

</div>
