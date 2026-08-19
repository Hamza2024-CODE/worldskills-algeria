@props([
    'target'      => 0,
    'duration'    => 2000,
    'label'       => '',
    'description' => '',
    'color'       => 'text-brand-500',
    'image'       => null,
    'icon'        => null,
    'prefix'      => '',
    'suffix'      => '+',
])

@php
    $numericTarget = (int) filter_var($target, FILTER_SANITIZE_NUMBER_INT);
    if ($numericTarget === 0 && (int)$target > 0) {
        $numericTarget = (int)$target;
    }
@endphp

<div x-data="{
    count: {{ $numericTarget }},
    target: {{ $numericTarget }},
    duration: {{ (int) $duration }},
    started: false,
    init() {
        if ('IntersectionObserver' in window) {
            this.count = 0;
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    this.startAnimation();
                    observer.disconnect();
                }
            }, { threshold: 0.1 });
            observer.observe(this.$el);
        } else {
            this.startAnimation();
        }
    },
    startAnimation() {
        if (this.started) return;
        this.started = true;

        const startTime = performance.now();
        const target = this.target;
        const duration = this.duration;

        const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);

        const step = (now) => {
            const elapsed  = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            this.count = Math.floor(easeOutQuart(progress) * target);
            if (progress !== 1) {
                requestAnimationFrame(step);
            } else {
                this.count = target;
            }
        };

        requestAnimationFrame(step);
    },
    formatCount(n) {
        if (n >= 1000) return (n / 1000).toFixed(n % 1000 === 0 ? 0 : 1) + 'k';
        return n.toLocaleString();
    }
}"
class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 text-center space-y-3 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group cursor-default select-none">

    {{-- Decorative glow --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-3xl"></div>

    {{-- Partner Image / Logo / Icon Support --}}
    @if($image)
        <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-50 p-2.5 border border-slate-100 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <img src="{{ $image }}" alt="{{ $label }}" class="max-h-full max-w-full object-contain filter drop-shadow">
        </div>
    @elseif($icon)
        <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-sm group-hover:scale-110 transition-transform duration-300">
            {!! $icon !!}
        </div>
    @endif

    {{-- Animated Number Counter --}}
    <div class="flex items-end justify-center gap-0.5 font-black leading-none {{ $color }}">
        @if($prefix) <span class="text-2xl sm:text-3xl mb-0.5">{{ $prefix }}</span> @endif
        <span x-text="target >= 1000 ? formatCount(count) : count.toLocaleString()"
              class="text-3xl sm:text-5xl font-black tabular-nums tracking-tight">{{ $numericTarget }}</span>
        @if($suffix) <span class="text-xl sm:text-2xl mb-1">{{ $suffix }}</span> @endif
    </div>

    {{-- Written Text Label & Description --}}
    <div class="space-y-1 relative z-10">
        @if($label)
            <h4 class="text-xs sm:text-sm font-black text-[#06205C] leading-snug">{{ $label }}</h4>
        @endif
        @if($description)
            <p class="text-[11px] font-medium text-slate-400 line-clamp-2 leading-relaxed">{{ $description }}</p>
        @endif
    </div>

</div>
