<div class="py-10 bg-[#F4F7FC] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        {{-- Top Header Card --}}
        <x-dashboard.page-header
            title="إدارة محتوى المنصة ومفاتيح فتح/غلق التسجيل (CMS Settings)"
            subtitle="التحكم الفوري في إتاحة وتسجيل المتنافسين، المشجعين، والاعتمادات والشركاء، والعداد التنازلي للمنافسات الوطنية."
        >
            <button type="button" wire:click="resetSettings" class="px-5 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md flex items-center gap-2 shadow-xs">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>إعادة تعيين</span>
            </button>
            <button type="button" wire:click="saveSettings" class="px-6 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white text-xs font-black shadow-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>حفظ التغييرات الآن</span>
            </button>
        </x-dashboard.page-header>

        @if($savedMessage)
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-black flex items-center gap-2 shadow-xs animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $savedMessage }}</span>
            </div>
        @endif

        <!-- Main Panel Tabs -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            
            <!-- Navigation Tabs Bar -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 pt-4 flex items-center gap-2 overflow-x-auto">
                <button type="button" wire:click="setTab('registration_switches')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'registration_switches' ? 'bg-white text-[#06205C] border-brand-500 shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>مفاتيح فتح وغلق التسجيل</span>
                </button>

                <button type="button" wire:click="setTab('countdown')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'countdown' ? 'bg-white text-[#06205C] border-brand-500 shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>إعدادات العد التنازلي</span>
                </button>

                <button type="button" wire:click="setTab('design')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'design' ? 'bg-white text-[#06205C] border-brand-500 shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    <span>تصميم البطاقة والألوان</span>
                </button>
            </div>

            <!-- Tab Content Container -->
            <div class="p-8">
                
                <form wire:submit.prevent="saveSettings" class="space-y-8">

                    <!-- TAB 0: Master Registration Switches (ON/OFF Toggles) -->
                    @if($activeTab === 'registration_switches')
                    <div class="space-y-6 animate-fade-in">
                        <div class="border-b border-slate-100 pb-4">
                            <h3 class="text-lg font-black text-[#06205C]">
                                مفاتيح التحكم في فتح وإغلاق التسجيلات العامة والخاصة 🔘
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 font-medium">
                                يمكنك تفعيل أو إطفاء أي مسار تسجيل بنقرة زر واحدة فورياً دون الحاجة لتعديل الكود.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <!-- Switch 1: Youth Competitors Registration -->
                            <div class="p-6 rounded-3xl bg-white border-2 {{ $registration_competitors_enabled ? 'border-brand-500/80 shadow-lg shadow-blue-500/5' : 'border-slate-200 bg-slate-50/50' }} transition space-y-4 relative overflow-hidden">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $registration_competitors_enabled ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $registration_competitors_enabled ? 'التسجيل مفتوح 🟢' : 'التسجيل مغلق 🔴' }}
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="text-sm font-black text-[#06205C]">1. تسجيل المتنافسين الشباب والوفود</h4>
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                                        يتحكم في استقبال طلبات ترشح الشباب والوفود الوطنية الموحدة بالمسابقة.
                                    </p>
                                </div>

                                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                                    <span class="text-xs font-bold text-slate-700">حالة المفتاح:</span>
                                    <button type="button" wire:click="toggleRegistration('competitors')" class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $registration_competitors_enabled ? 'bg-brand-500' : 'bg-slate-300' }}">
                                        <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $registration_competitors_enabled ? '-translate-x-7' : 'translate-x-0' }}"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- Switch 2: Official Supporters & Spectators Registration -->
                            <div class="p-6 rounded-3xl bg-white border-2 {{ $registration_supporters_enabled ? 'border-emerald-500/80 shadow-lg shadow-emerald-500/5' : 'border-slate-200 bg-slate-50/50' }} transition space-y-4 relative overflow-hidden">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $registration_supporters_enabled ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $registration_supporters_enabled ? 'التسجيل مفتوح 🟢' : 'التسجيل مغلق 🔴' }}
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="text-sm font-black text-[#06205C]">2. تسجيل التشجيع الرسمي والزوار</h4>
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                                        يتحكم في تسجيل الجمهور والمشجعين والزوار لحضور المنافسات بمركز المؤتمرات بوهران.
                                    </p>
                                </div>

                                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                                    <span class="text-xs font-bold text-slate-700">حالة المفتاح:</span>
                                    <button type="button" wire:click="toggleRegistration('supporters')" class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $registration_supporters_enabled ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                        <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $registration_supporters_enabled ? '-translate-x-7' : 'translate-x-0' }}"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- Switch 3: Accreditation & Badges Registration -->
                            <div class="p-6 rounded-3xl bg-white border-2 {{ $registration_accreditation_enabled ? 'border-amber-500/80 shadow-lg shadow-amber-500/5' : 'border-slate-200 bg-slate-50/50' }} transition space-y-4 relative overflow-hidden">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $registration_accreditation_enabled ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $registration_accreditation_enabled ? 'التسجيل مفتوح 🟢' : 'التسجيل مغلق 🔴' }}
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="text-sm font-black text-[#06205C]">3. تسجيل الاعتماد والشارات الرسمية</h4>
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                                        يتحكم في تسجيل واستصدار شارات الاعتماد للخبراء، المحكمين، والوفود الإعلامية.
                                    </p>
                                </div>

                                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                                    <span class="text-xs font-bold text-slate-700">حالة المفتاح:</span>
                                    <button type="button" wire:click="toggleRegistration('accreditation')" class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $registration_accreditation_enabled ? 'bg-amber-500' : 'bg-slate-300' }}">
                                        <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $registration_accreditation_enabled ? '-translate-x-7' : 'translate-x-0' }}"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- Switch 4: Official Partners & Sponsors Page -->
                            <div class="p-6 rounded-3xl bg-white border-2 {{ $page_partners_enabled ? 'border-purple-500/80 shadow-lg shadow-purple-500/5' : 'border-slate-200 bg-slate-50/50' }} transition space-y-4 relative overflow-hidden">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $page_partners_enabled ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                        {{ $page_partners_enabled ? 'الصفحة مفعلة 🟢' : 'الصفحة معطلة 🔴' }}
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="text-sm font-black text-[#06205C]">4. صفحة وقسم الشركاء والرعاة</h4>
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                                        يتحكم في تفعيل أو إطفاء عرض صفحة الشركاء والرعاة بالكامل ورابطها في الهيدر والصفحة الرئيسية.
                                    </p>
                                </div>

                                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                                    <span class="text-xs font-bold text-slate-700">حالة المفتاح:</span>
                                    <button type="button" wire:click="toggleRegistration('partners')" class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $page_partners_enabled ? 'bg-purple-600' : 'bg-slate-300' }}">
                                        <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $page_partners_enabled ? '-translate-x-7' : 'translate-x-0' }}"></span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif

                    <!-- TAB 1: Countdown Settings -->
                    @if($activeTab === 'countdown')
                    <div class="space-y-6 animate-fade-in">
                        <div class="p-5 rounded-2xl bg-blue-50/60 border border-blue-200 flex items-center justify-between">
                            <div>
                                <span class="font-black text-xs text-[#06205C] block">تفعيل العداد التنازلي التفاعلي</span>
                                <span class="text-[11px] text-slate-600">إظهار أو إخفاء بطاقة المفكرة الورقية ثلاثية الأبعاد بالصفحة الرئيسية</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="countdown_enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                            </label>
                        </div>
                    </div>
                    @endif

                    <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                        <button type="button" wire:click="saveSettings" class="px-8 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-lg transition">
                            حفظ وتطبيق جميع الإعدادات فوراً
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
