<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#06205C] text-white flex items-center justify-center shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-[#06205C]">محرر التنبيهات المتقدم (Audience Builder & Notification Composer)</h1>
                <p class="text-xs text-slate-500 font-medium">
                    إنشاء وجدولة التنبيهات مع التحديد الدقيق للوفود، المشاركين، الحكام، الوجبات والسكن.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
            رجوع للقائمة
        </a>
    </div>

    {{-- QUICK TEMPLATES BAR --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm space-y-2">
        <span class="text-xs font-black text-[#06205C] block uppercase tracking-wider">قوالب التنبيهات السريعة (Quick Templates)</span>
        <div class="flex flex-wrap gap-2 pt-1">
            <button wire:click="applyTemplate('MEAL')" type="button" class="px-3 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <x-ws.icon name="sparkles" class="w-4 h-4 inline-block text-amber-500" /> <span>تنبيه وجبة مطعم</span>
            </button>
            <button wire:click="applyTemplate('TECHNICAL_MEETING')" type="button" class="px-3 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-800 border border-indigo-200 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <x-ws.icon name="building-library" class="w-4 h-4 inline-block text-blue-500" /> <span>تنبيه اجتماع تقني</span>
            </button>
            <button wire:click="applyTemplate('ACCOMMODATION')" type="button" class="px-3 py-2 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <x-ws.icon name="building-office" class="w-4 h-4 inline-block text-indigo-500" /> <span>تنبيه سكن وإقامة</span>
            </button>
            <button wire:click="applyTemplate('COMPETITION')" type="button" class="px-3 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <x-ws.icon name="trophy" class="w-4 h-4 inline-block text-amber-600" /> <span>تنبيه مسابقة وجولات</span>
            </button>
            <button wire:click="applyTemplate('URGENT')" type="button" class="px-3 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-200 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <x-ws.icon name="exclamation-triangle" class="w-4 h-4 inline-block text-rose-600" /> <span>تنبيه عاجل من الإدارة</span>
            </button>
        </div>
    </div>

    <form wire:submit.prevent="saveAndDispatch" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT COL: CONTENT & MESSAGING -->
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                    <h2 class="text-base font-black text-[#06205C] border-b border-slate-100 pb-3">1. محتوى التنبيه (Multilingual Content)</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">نوع التنبيه (Type) *</label>
                            <select wire:model.live="type" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                                <option value="GENERAL">GENERAL (إعلان عام)</option>
                                <option value="TECHNICAL_MEETING">TECHNICAL_MEETING (اجتماع تقني)</option>
                                <option value="MEAL">MEAL (وجبة/مطعم)</option>
                                <option value="ACCOMMODATION">ACCOMMODATION (سكن)</option>
                                <option value="COMPETITION">COMPETITION (مسابقة)</option>
                                <option value="SCHEDULE">SCHEDULE (تغيير البرنامج)</option>
                                <option value="URGENT">URGENT (عاجل)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">الأولوية (Priority) *</label>
                            <select wire:model.live="priority" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                                <option value="LOW">LOW / منخفضة</option>
                                <option value="NORMAL">NORMAL / عادية</option>
                                <option value="HIGH">HIGH / مرتفعة</option>
                                <option value="URGENT">URGENT / عاجل جداً</option>
                            </select>
                        </div>
                    </div>

                    {{-- ARABIC CONTENT --}}
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <span class="text-xs font-black text-[#06205C] block">النص بالعربية (مطلوب) *</span>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">العنوان (Title AR)</label>
                            <input type="text" wire:model="title_ar" required placeholder="مثال: وجبة الغداء متاحة الآن في المطعم المركزي" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white">
                            @error('title_ar') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">نص الرسالة (Body AR)</label>
                            <textarea wire:model="body_ar" rows="3" required placeholder="أدخل تفاصيل التنبيه هنا..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-medium bg-white"></textarea>
                            @error('body_ar') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- FRENCH CONTENT --}}
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <span class="text-xs font-black text-[#06205C] block">Texte en Français (Optionnel)</span>
                        <div>
                            <input type="text" wire:model="title_fr" placeholder="Titre en Français..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium bg-white">
                        </div>
                        <div>
                            <textarea wire:model="body_fr" rows="2" placeholder="Message en Français..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium bg-white"></textarea>
                        </div>
                    </div>

                    {{-- ENGLISH CONTENT --}}
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <span class="text-xs font-black text-[#06205C] block">English Content (Optional)</span>
                        <div>
                            <input type="text" wire:model="title_en" placeholder="English Title..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium bg-white">
                        </div>
                        <div>
                            <textarea wire:model="body_en" rows="2" placeholder="English Message..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium bg-white"></textarea>
                        </div>
                    </div>

                </div>

                {{-- ACTION TYPE & DEEP LINK RESOLVER --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-black text-[#06205C] border-b border-slate-100 pb-3">2. الإجراء والتحويل التفاعلي (Safe Action Link)</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">نوع الإجراء (Action Type)</label>
                            <select wire:model="action_type" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                                <option value="">بدون إجراء (إشعار فقط)</option>
                                <option value="MEAL_SLOT">MEAL_SLOT (فتح ماسح الوجبة / المطعم)</option>
                                <option value="ACCOMMODATION">ACCOMMODATION (عرض معلومات السكن)</option>
                                <option value="TECHNICAL_MEETING">TECHNICAL_MEETING (اجتماع تقني)</option>
                                <option value="COMPETITION">COMPETITION (لوحة المنافسات)</option>
                                <option value="ACCREDITATION">ACCREDITATION (لوحة الاعتمادات والشارات)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">رقم/معرف الهدف (Action ID)</label>
                            <input type="text" wire:model="action_id" placeholder="مثال: رقم الخانة 25" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COL: AUDIENCE BUILDER & SCHEDULE -->
            <div class="space-y-6">

                {{-- AUDIENCE ESTIMATOR BADGE --}}
                <div class="bg-[#06205C] text-white p-6 rounded-3xl shadow-lg space-y-2 text-center">
                    <span class="text-xs font-bold text-white/80 uppercase tracking-wider block">إجمالي المستهدفين المتوقعين</span>
                    <div class="text-4xl font-black text-emerald-400">
                        {{ number_format($estimatedRecipients) }}
                    </div>
                    <span class="text-[11px] text-white/70 block">مستخدماً معتمداً سيستلمون التنبيه</span>
                </div>

                {{-- AUDIENCE TARGETING SELECTORS --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-black text-[#06205C] border-b border-slate-100 pb-3">3. تحديد الجمهور (Audience Builder)</h2>

                    {{-- ROLES TARGET --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">تصفية حسب الأدوار (Roles)</label>
                        <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                            @foreach([
                                'PARTICIPANT' => 'مشارك متنافس',
                                'DELEGATION HEAD' => 'رئيس وفد',
                                'EXPERT JUDGE' => 'حكم خبير',
                                'MEDIA' => 'صحفي إعلامي',
                                'VIP' => 'ضيف شرف',
                                'ORGANIZER' => 'منظم'
                            ] as $rKey => $rLabel)
                            <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 border border-slate-200/80 cursor-pointer">
                                <input type="checkbox" wire:model.live="targetRoles" value="{{ $rKey }}" class="w-4 h-4 rounded border-slate-300">
                                <span class="text-[11px] text-slate-700">{{ $rLabel }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- DELEGATIONS / COUNTRIES TARGET --}}
                    <div class="space-y-1.5 pt-2">
                        <label class="block text-xs font-bold text-slate-700">تصفية حسب الوفد / الدولة (Delegation)</label>
                        <select wire:model.live="targetCountries" multiple class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 h-28">
                            @foreach($countries as $cnt)
                            <option value="{{ $cnt->id }}">{{ $cnt->name_ar }} ({{ $cnt->code }})</option>
                            @endforeach
                        </select>
                        <span class="text-[10px] text-slate-400 block">اضغط Ctrl لاختيار أكثر من دولة</span>
                    </div>

                    {{-- SKILLS TARGET --}}
                    <div class="space-y-1.5 pt-2">
                        <label class="block text-xs font-bold text-slate-700">تصفية حسب التخصص (Skill/Trade)</label>
                        <select wire:model.live="targetSkills" multiple class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50 h-28">
                            @foreach($skills as $sk)
                            <option value="{{ $sk->id }}">{{ $sk->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MEAL SLOT TARGET --}}
                    <div class="space-y-1.5 pt-2">
                        <label class="block text-xs font-bold text-slate-700">تصفية حسب استحقاق الوجبة (Meal Slot)</label>
                        <select wire:model.live="targetMealSlot" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                            <option value="0">— اختيار وجبة لاستخراج المستحقين تلقائياً —</option>
                            @foreach($mealSlots as $slot)
                            <option value="{{ $slot->id }}">{{ $slot->meal_label }} — {{ $slot->restaurant?->name_ar }} ({{ $slot->date }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- SCHEDULING & EXPIRATION --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-black text-[#06205C] border-b border-slate-100 pb-3">4. الجدولة والانتهاء</h2>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">وقت الإرسال المجدول (اختياري)</label>
                        <input type="datetime-local" wire:model="scheduled_at" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                        <span class="text-[10px] text-slate-400 block mt-1">اتركه فارغاً للإرسال الفوري الآن</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">وقت انتهاء الصلاحية (Expiration)</label>
                        <input type="datetime-local" wire:model="expires_at" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                    </div>
                </div>

                {{-- SUBMIT BUTTONS --}}
                <div class="space-y-3">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm shadow-xl shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>اعتماد وإرسال التنبيه الآن (Dispatch)</span>
                    </button>
                </div>

            </div>

        </div>
    </form>

</div>
