<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.outside="open = false" type="button" class="px-3 py-1.5 rounded-full bg-slate-100 text-xs font-bold text-[#06205C] hover:bg-slate-200 transition flex items-center gap-1.5 border border-slate-200 shadow-2xs">
        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.357 6 17.555"/></svg>
        <span class="uppercase font-mono font-black text-[11px] text-[#0066FF]">{{ app()->getLocale() }}</span>
        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
    <div x-show="open" x-cloak x-transition class="absolute top-full ltr:right-0 rtl:left-0 mt-2 w-36 rounded-2xl bg-white shadow-xl border border-slate-100 py-1.5 z-50 overflow-hidden">
        <a href="{{ route('lang.switch', 'ar') }}" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2 text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'text-[#0066FF] bg-blue-50 font-black' : 'text-[#06205C] hover:bg-slate-50' }}">
            <span>العربية</span>
            <span class="text-[10px] text-slate-400 font-mono">AR</span>
        </a>
        <a href="{{ route('lang.switch', 'fr') }}" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2 text-xs font-bold transition {{ app()->getLocale() === 'fr' ? 'text-[#0066FF] bg-blue-50 font-black' : 'text-[#06205C] hover:bg-slate-50' }}">
            <span>Français</span>
            <span class="text-[10px] text-slate-400 font-mono">FR</span>
        </a>
        <a href="{{ route('lang.switch', 'en') }}" data-navigate-ignore rel="external" class="flex items-center justify-between px-4 py-2 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'text-[#0066FF] bg-blue-50 font-black' : 'text-[#06205C] hover:bg-slate-50' }}">
            <span>English</span>
            <span class="text-[10px] text-slate-400 font-mono">EN</span>
        </a>
    </div>
</div>
