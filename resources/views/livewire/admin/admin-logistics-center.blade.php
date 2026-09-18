<div class="space-y-6 pb-8">

    {{-- HEADER --}}
    <x-dashboard.page-header
        title="مركز القيادة والتحكم اللوجستي"
        subtitle="نظام إدارة التجهيزات، السكن، وخطة النقل والمواصلات لمسابقة مهارات الجزائر"
    />

    {{-- MODULE CARDS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- EQUIPMENT CARD --}}
        <a href="{{ route('admin.equipment') }}" class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-blue-500 rounded-2xl p-6 transition shadow-xs hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-105 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <span class="text-2xl font-black text-blue-600 dark:text-blue-400 font-mono">{{ number_format($totalEquipment) }}</span>
            </div>
            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 mb-1 group-hover:text-blue-600 transition">إدارة المعدات والتجهيزات</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">معدات ورشات العمل، الأدوات، الأجهزة ومستويات السلامة والأمان.</p>
            <div class="flex items-center gap-1 text-xs font-bold text-blue-600">
                <span>الانتقال لإدارة المعدات</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </div>
        </a>

        {{-- ACCOMMODATIONS CARD --}}
        <a href="{{ route('admin.accommodations') }}" class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-blue-500 rounded-2xl p-6 transition shadow-xs hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:scale-105 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="text-end">
                    <span class="text-2xl font-black text-purple-600 dark:text-purple-400 font-mono block">{{ number_format($totalAccommodations) }}</span>
                    <span class="text-xs text-slate-400 font-bold">{{ number_format($totalCapacity) }} سرير</span>
                </div>
            </div>
            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 mb-1 group-hover:text-blue-600 transition">إدارة السكن والإقامة</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">الفنادق، الإقامات، توزيع الغرف، والطاقة الاستيعابية للوفود والمتنافسين.</p>
            <div class="flex items-center gap-1 text-xs font-bold text-blue-600">
                <span>الانتقال لإدارة السكن</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </div>
        </a>

        {{-- TRANSPORT CARD --}}
        <a href="{{ route('admin.accommodations') }}" class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-blue-500 rounded-2xl p-6 transition shadow-xs hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-105 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.5.01M13 16H9m4 0h2m4 0h2v-5l-3-5H17M3 16h2.5"/>
                    </svg>
                </div>
                <div class="text-end">
                    <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 font-mono block">{{ number_format($totalTransportRoutes) }}</span>
                    <span class="text-xs text-slate-400 font-bold">{{ number_format($totalTrips) }} رحلة</span>
                </div>
            </div>
            <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 mb-1 group-hover:text-blue-600 transition">إدارة النقل والمواصلات</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">خطوط ومسارات النقل، المواعيد، وجدول الرحلات الميدانية.</p>
            <div class="flex items-center gap-1 text-xs font-bold text-blue-600">
                <span>الانتقال لإدارة النقل</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </div>
        </a>

    </div>

</div>
