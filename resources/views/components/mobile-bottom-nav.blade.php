<!-- Native Mobile App Bottom Tab Bar (Context & Role Dynamic) -->
@php
    $user = auth()->user();
    $role = $user?->roles?->first()?->name ?? 'GUEST';

    $myBadgeUrl = '#';
    if ($user) {
        $identifier = $user->uuid ?? (string)$user->id;
        $myBadgeUrl = route('accreditation.badge', ['identifier' => $identifier]);
    }

    $userReg = null;
    $isRejectedCandidate = false;
    if ($user && $role === \App\Enums\RoleEnum::PARTICIPANT->value) {
        $userReg = \App\Models\Registration::whereHas('participant', fn($q) => $q->where('user_id', $user->id)->orWhere('email', $user->email))->first();
        if ($userReg) {
            $st = is_object($userReg->status) ? ($userReg->status->value ?? 'APPROVED') : ($userReg->status ?? 'APPROVED');
            if (strtoupper((string)$st) === 'REJECTED') {
                $isRejectedCandidate = true;
            }
        }
    }

    $tabs = [];

    if (!$user || $role === 'GUEST') {
        $tabs = [
            [
                'label' => __('messages.home'),
                'url' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => __('messages.skills'),
                'url' => route('skills'),
                'active' => request()->routeIs('skills*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/>',
            ],
            [
                'label' => __('messages.register'),
                'url' => route('registration'),
                'active' => request()->routeIs('registration*'),
                'is_primary' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>',
            ],
            [
                'label' => __('messages.news'),
                'url' => route('news'),
                'active' => request()->routeIs('news*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
            ],
            [
                'label' => __('messages.login'),
                'url' => route('login'),
                'active' => request()->routeIs('login'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>',
            ],
        ];
    } elseif ($role === \App\Enums\RoleEnum::PARTICIPANT->value) {
        $tabs = [
            [
                'label' => __('messages.home'),
                'url' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Mon Espace' : (app()->getLocale() === 'en' ? 'Dashboard' : 'فضائي')),
                'url' => route('participant.dashboard'),
                'active' => request()->routeIs('participant.dashboard'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 00-2 2h2a2 2 0 00-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Mon Badge' : (app()->getLocale() === 'en' ? 'My Badge' : 'شارتي الرسمية')),
                'url' => $isRejectedCandidate ? '#' : $myBadgeUrl,
                'active' => request()->routeIs('accreditation.badge*'),
                'is_primary' => true,
                'is_rejected' => $isRejectedCandidate,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            ],
            [
                'label' => __('messages.skills'),
                'url' => route('skills'),
                'active' => request()->routeIs('skills*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Mon Profil' : (app()->getLocale() === 'en' ? 'My Profile' : 'حسابي')),
                'url' => route('profile'),
                'active' => request()->routeIs('profile'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            ],
        ];
    } else {
        // Admins, Judges, Delegation Admins, Media Managers
        $dashUrl = match($role) {
            'SUPER_ADMIN', 'NATIONAL_ADMIN' => route('admin.dashboard'),
            'MEDIA_MANAGER'                 => route('admin.media.dashboard'),
            'EXECUTIVE_VIEWER'              => route('executive.dashboard'),
            'COUNTRY_ADMIN'                 => route('country.dashboard'),
            'ORGANIZATION_ADMIN'            => route('organization.dashboard'),
            'JUDGE', 'EXPERT'               => route('judge.dashboard'),
            default                         => route('admin.dashboard'),
        };

        $scannerUrl = \Illuminate\Support\Facades\Route::has('admin.scanner') 
            ? route('admin.scanner') 
            : (\Illuminate\Support\Facades\Route::has('scanner') ? route('scanner') : route('admin.accreditations'));

        $tabs = [
            [
                'label' => __('messages.home'),
                'url' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Dashboard Admin' : (app()->getLocale() === 'en' ? 'Admin Board' : 'فضائي الإداري')),
                'url' => $dashUrl,
                'active' => request()->routeIs('*dashboard*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 00-2 2h2a2 2 0 00-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Scanner QR' : (app()->getLocale() === 'en' ? 'QR Scanner' : 'الماسح الضوئي')),
                'url' => $scannerUrl,
                'active' => request()->routeIs('*scanner*'),
                'is_primary' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Accréditations' : (app()->getLocale() === 'en' ? 'Accreditations' : 'الاعتمادات')),
                'url' => route('admin.accreditations'),
                'active' => request()->routeIs('admin.accreditations*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Profil' : (app()->getLocale() === 'en' ? 'Profile' : 'حسابي')),
                'url' => route('profile'),
                'active' => request()->routeIs('profile'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            ],
        ];
    }
@endphp

<div x-data="{ showRejectedBadgePopup: false }">
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-2xl border-t border-slate-200/90 shadow-[0_-8px_30px_rgba(0,0,0,0.12)] px-2 pt-2 pb-3 flex items-center justify-around print:hidden select-none" style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom));">
        @foreach($tabs as $tab)
            @if(!empty($tab['is_primary']))
                @if(!empty($tab['is_rejected']))
                    <button type="button" @click="showRejectedBadgePopup = true" class="flex flex-col items-center justify-center -mt-6 relative group cursor-pointer">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-rose-500 via-rose-600 to-rose-700 text-white flex items-center justify-center shadow-xl shadow-rose-500/30 border-4 border-white transform active:scale-90 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $tab['icon'] !!}
                            </svg>
                        </div>
                        <span class="text-[9px] font-black text-rose-600 mt-1">{{ $tab['label'] }}</span>
                    </button>
                @else
                    <a href="{{ $tab['url'] }}" class="flex flex-col items-center justify-center -mt-6 relative group">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-[#0066FF] via-[#0080FF] to-[#00B8FF] text-white flex items-center justify-center shadow-xl shadow-blue-500/40 border-4 border-white transform active:scale-90 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $tab['icon'] !!}
                            </svg>
                        </div>
                        <span class="text-[9px] font-black text-[#0066FF] mt-1">{{ $tab['label'] }}</span>
                    </a>
                @endif
            @else
                @if(!empty($tab['is_rejected']))
                    <button type="button" @click="showRejectedBadgePopup = true" class="flex flex-col items-center justify-center py-1 px-2 sm:px-3 rounded-2xl transition active:scale-95 text-slate-500 hover:text-slate-900 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $tab['icon'] !!}
                        </svg>
                        <span class="text-[10px] font-bold mt-0.5 whitespace-nowrap">{{ $tab['label'] }}</span>
                    </button>
                @else
                    <a href="{{ $tab['url'] }}" class="flex flex-col items-center justify-center py-1 px-2 sm:px-3 rounded-2xl transition active:scale-95 {{ $tab['active'] ? 'text-[#0066FF] font-black' : 'text-slate-500 hover:text-slate-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $tab['icon'] !!}
                        </svg>
                        <span class="text-[10px] font-bold mt-0.5 whitespace-nowrap">{{ $tab['label'] }}</span>
                    </a>
                @endif
            @endif
        @endforeach
    </div>

    <!-- ══ REJECTED BADGE POPUP MODAL ══ -->
    <template x-teleport="body">
        <div x-show="showRejectedBadgePopup" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center space-y-4 shadow-2xl border border-slate-200" dir="rtl">
                <div class="w-16 h-16 rounded-2xl bg-rose-100 border-2 border-rose-200 text-rose-600 flex items-center justify-center mx-auto shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">تنبيه الاعتماد</h3>
                    <p class="text-xs font-bold text-slate-500 mt-1">بطاقة الاعتماد غير متاحة للملفات المرفوضة</p>
                </div>
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-black leading-relaxed">
                    أنت مرفوض لا يمكنك الحصول على الشارة
                </div>
                <button type="button" @click="showRejectedBadgePopup = false" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition shadow-md">
                    إغلاق
                </button>
            </div>
        </div>
    </template>
</div>
