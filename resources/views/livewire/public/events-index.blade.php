<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Agenda WorldSkills Algeria 2026' : (app()->getLocale() === 'en' ? 'WorldSkills Algeria Events 2026' : 'أحداث وفعاليات أولمبياد المهن 2026') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Découvrez le programme des qualifications, séminaires et cérémonies.' : (app()->getLocale() === 'en' ? 'Explore upcoming competition events, seminars and ceremonies.' : 'تابع برنامج التصفيات والندوات وحفلات التتويج الرسمية.') }}
            </p>
        </div>

        <!-- Events List -->
        <div class="space-y-6 max-w-4xl mx-auto">
            @forelse($events as $event)
                <div class="bg-white rounded-3xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 border border-slate-200/80 shadow-md hover:shadow-lg transition">
                    <div class="space-y-2">
                        <span class="px-3 py-1 rounded-xl bg-brand-50 text-brand-500 font-extrabold text-[11px] border border-brand-200 inline-block">
                            {{ $event->start_at ? $event->start_at->format('Y-m-d H:i') : '2026 / 2027' }}
                        </span>
                        <h3 class="text-xl font-black text-[#06205C]">{{ $event->getLocalized('title') }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ $event->getLocalized('summary') }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center text-slate-400 font-medium text-xs border border-slate-200">
                    {{ app()->getLocale() === 'fr' ? 'Aucun événement programmé pour le moment.' : (app()->getLocale() === 'en' ? 'No events currently scheduled.' : 'لا تتوفر فعاليات مبرمجة حالياً.') }}
                </div>
            @endforelse
        </div>

    </div>
</div>
