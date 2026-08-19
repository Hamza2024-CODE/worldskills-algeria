<div class="space-y-6 pb-8" x-data="{ selected: @entangle('selectedUsers') }">

    {{-- HEADER --}}
    <x-dashboard.page-header
        title="مركز طباعة وإصدار شارات الاعتماد (Accreditation Badges)"
        subtitle="طباعة شارات الاعتماد المشفرة بالـ QR لجميع الأدوار الرسمية: مشارك، رئيس وفد، حكم، إعلامي، VIP، SPEAKER، منظم، متطوع."
    >
        <button wire:click="openCreate()" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>إصدار شارات مخصصة</span>
        </button>
        <a href="{{ route('admin.accreditations.batch-print', array_filter(['role' => $filterRole, 'country_id' => $filterCountry])) }}" target="_blank" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>طباعة جميع الشارات المعروضة (Batch Print)</span>
        </a>
    </x-dashboard.page-header>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-sm flex items-center justify-between">
        <span>✓ {{ session('success') }}</span>
    </div>
    @endif

    {{-- SEARCH & ROLE / DELEGATION FILTERS --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <div class="flex-1 relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم المسجل أو البريد أو رقم الاعتماد..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-[#06205C] focus:ring-2 focus:ring-brand-500 bg-slate-50">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            {{-- Delegation / Country Filter --}}
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-500 whitespace-nowrap">الوفد / الدولة:</span>
                <select wire:model.live="filterCountry" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-black text-[#06205C] bg-white">
                    <option value="">جميع الوفود / الدول</option>
                    @foreach($countries as $cnt)
                    <option value="{{ $cnt->id }}">{{ $cnt->name_ar }} ({{ $cnt->code }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Role Filter --}}
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-500 whitespace-nowrap">الدور:</span>
                <select wire:model.live="filterRole" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-black text-[#06205C] bg-white">
                    <option value="">جميع الأدوار الرسمية (All Roles)</option>
                    <option value="COMPETITOR">COMPETITOR / مشارك متنافس</option>
                    <option value="DELEGATION HEAD">DELEGATION HEAD / رئيس وفد</option>
                    <option value="EXPERT JUDGE">EXPERT JUDGE / حكم خبير</option>
                    <option value="MEDIA">MEDIA / صحفي إعلامي</option>
                    <option value="VIP">VIP / ضيف شرف</option>
                    <option value="SPEAKER">SPEAKER / محاضر متحدث</option>
                    <option value="ORGANIZER">ORGANIZER / منظم</option>
                    <option value="VOLUNTEER">VOLUNTEER / متطوع</option>
                </select>
            </div>
        </div>
    </div>

    {{-- BATCH ACTION FLOATING BAR --}}
    @if(count($selectedUsers) > 0)
    <div class="bg-[#06205C] text-white p-4 rounded-2xl shadow-xl flex items-center justify-between animate-fadeIn">
        <div class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-black text-sm">
                {{ count($selectedUsers) }}
            </span>
            <span class="text-xs font-bold">عضواً محددين لطباعة الشارات</span>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="$set('selectedUsers', [])" class="text-xs text-white/70 hover:text-white font-bold">
                إلغاء التحديد
            </button>
            <a href="{{ route('admin.accreditations.batch-print', ['ids' => implode(',', $selectedUsers)]) }}" target="_blank"
               class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة الشارات المحددة (A4 Print Selected)</span>
            </a>
        </div>
    </div>
    @endif

    {{-- USERS & BADGES TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-4 py-4 text-center w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="w-4 h-4 rounded border-slate-300">
                        </th>
                        <th class="px-5 py-4 text-start">المستخدم المعتمد</th>
                        <th class="px-5 py-4 text-start">رقم الاعتماد</th>
                        <th class="px-5 py-4 text-start">الدور المعتمد</th>
                        <th class="px-5 py-4 text-start">الدولة / الوفد / التخصص</th>
                        <th class="px-5 py-4 text-start">حالة الحساب</th>
                        <th class="px-5 py-4 text-end">طباعة الشارة (Badge)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold">
                    @forelse($users as $u)
                        @php
                            $reg       = $u->participant?->registrations?->first();
                            $badge     = $u->badges->first();
                            $userRole  = $u->roles->first()?->name;

                            $roleTitle = $badge?->role_title ?? match ($userRole) {
                                'MEDIA_MANAGER'                     => 'MEDIA',
                                'EXECUTIVE_VIEWER'                  => 'VIP',
                                'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
                                'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                                'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                                default                             => 'COMPETITOR',
                            };

                            $badgeColor = match($roleTitle) {
                                'SPEAKER'          => 'bg-purple-100 text-purple-800 border-purple-300',
                                'VIP'              => 'bg-pink-100 text-pink-800 border-pink-300',
                                'DELEGATION HEAD'  => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'EXPERT JUDGE'     => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                'MEDIA'            => 'bg-amber-100 text-amber-800 border-amber-300',
                                'ORGANIZER'        => 'bg-slate-200 text-slate-800 border-slate-300',
                                'VOLUNTEER'        => 'bg-teal-100 text-teal-800 border-teal-300',
                                default            => 'bg-blue-100 text-blue-800 border-blue-300',
                            };

                            $identifier  = $reg?->registration_number ?? $badge?->access_token ?? $u->uuid;
                            $nameAr      = $u->participant?->first_name_ar ? ($u->participant->first_name_ar . ' ' . $u->participant->last_name_ar) : $u->name;
                            $nameLatin   = $u->participant?->first_name_latin ? ($u->participant->first_name_latin . ' ' . $u->participant->last_name_latin) : $u->email;
                            $regNumber   = $reg?->registration_number ?? ($badge?->badge_uuid ? substr($badge->badge_uuid, 0, 18) : ('USR-' . str_pad($u->id, 5, '0', STR_PAD_LEFT)));
                            $countryName = $reg?->country?->name_ar ?? $u->country?->name_ar ?? 'الجزائر';
                            $skillOrOrg  = $reg?->skill?->name_ar ?? $u->organization?->name_ar ?? 'المنصة الوطنية';
                            $photoUrl    = $u->avatar_url;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" wire:model.live="selectedUsers" value="{{ $u->id }}" class="w-4 h-4 rounded border-slate-300">
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $photoUrl }}" alt="Photo" class="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0">
                                    <div>
                                        <span class="font-black text-[#06205C] block text-xs">
                                            {{ $nameAr }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-mono block">
                                            {{ $nameLatin }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-mono font-bold text-brand-600">{{ $regNumber }}</td>
                            <td class="px-5 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black border font-mono {{ $badgeColor }}">
                                    {{ $roleTitle }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="block font-bold text-slate-800">{{ $countryName }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ $skillOrOrg }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    مفعل معتمد ✓
                                </span>
                            </td>
                            <td class="px-5 py-4 text-end">
                                <a href="{{ route('accreditation.badge', ['identifier' => $identifier]) }}" target="_blank" class="px-4 py-2 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 font-black text-xs transition inline-flex items-center gap-1.5 border border-brand-200 shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    <span>طباعة الشارة (Badge)</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 font-bold">
                                لا يوجد مستخدمين معتمدين يطابقون خيارات البحث حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $users->links() }}</div>
        @endif
    </div>

    {{-- MODAL FORM: CUSTOM BADGE ISSUANCE --}}
    @if($formOpen)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-slate-900 text-lg">إصدار شارة اعتماد جديدة</h2>
                <button wire:click="$set('formOpen', false)" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-3 text-xs font-bold">
                <div>
                    <label class="block text-slate-700 mb-1">اختر المستخدم *</label>
                    <select wire:model="user_id_badge" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                        <option value="0">اختر مسجلاً / عضواً من النظام</option>
                        @foreach($allUsers as $usr)
                        <option value="{{ $usr->id }}">{{ $usr->name }} — ({{ $usr->roles->first()?->name ?? 'مستخدم' }}) — {{ $usr->email }}</option>
                        @endforeach
                    </select>
                    @error('user_id_badge') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">الدور المعتمد للشارة *</label>
                    <select wire:model="role_title" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 font-black">
                        <option value="COMPETITOR">COMPETITOR / مشارك متنافس</option>
                        <option value="DELEGATION HEAD">DELEGATION HEAD / رئيس وفد</option>
                        <option value="EXPERT JUDGE">EXPERT JUDGE / حكم خبير</option>
                        <option value="MEDIA">MEDIA / صحفي إعلامي</option>
                        <option value="VIP">VIP / ضيف شرف</option>
                        <option value="SPEAKER">SPEAKER / محاضر متحدث</option>
                        <option value="ORGANIZER">ORGANIZER / منظم</option>
                        <option value="VOLUNTEER">VOLUNTEER / متطوع</option>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">تاريخ الانتهاء (اختياري)</label>
                    <input wire:model="valid_until" type="date" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button wire:click="$set('formOpen', false)" class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs">إلغاء</button>
                <button wire:click="issue()" class="px-5 py-2 rounded-xl bg-[#06205C] text-white font-black text-xs">إصدار الشارة</button>
            </div>
        </div>
    </div>
    @endif

</div>
