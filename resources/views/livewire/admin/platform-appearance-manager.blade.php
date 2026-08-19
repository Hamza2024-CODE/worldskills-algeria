<div class="space-y-8">
    {{-- Studio Header --}}
    <x-dashboard.page-header
        :title="app()->getLocale() === 'fr' ? 'Studio d\'Apparence & Design Tokens' : (app()->getLocale() === 'en' ? 'Platform Appearance Studio' : 'استوديو مظهر المنصة والهوية البصرية')"
        :subtitle="app()->getLocale() === 'fr' ? 'Personnalisez la charte graphique et les éléments visuels de la plateforme.' : (app()->getLocale() === 'en' ? 'Dynamically control design tokens, colors, branding, and assets across all portals.' : 'إدارة رموز التصميم، ألوان الهوية الوطنية، ومرفقات المنصة ديناميكياً بدون لمس الكود.')"
    >
        <button wire:click="resetDefaults" wire:confirm="{{ __('هل أنت أصلًا متأكد من إعادة ضبط رموز المظهر إلى الافتراضيات؟') }}" class="px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-extrabold text-xs transition backdrop-blur-md">
            {{ app()->getLocale() === 'fr' ? 'Réinitialiser' : (app()->getLocale() === 'en' ? 'Reset Defaults' : 'إعادة ضبط الافتراضيات') }}
        </button>
        <button wire:click="saveAppearance" class="px-6 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Enregistrer les Changements' : (app()->getLocale() === 'en' ? 'Save Appearance Tokens' : 'حفظ رموز المظهر') }}</span>
        </button>
    </x-dashboard.page-header>

    <!-- Alert Feedback -->
    @if ($savedMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>{{ $savedMessage }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Form Controls -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Coming Soon Mode Settings Card -->
            <div class="rounded-3xl p-6 border transition-all duration-300 shadow-lg {{ $coming_soon_mode ? 'bg-amber-500/10 border-amber-500/50 dark:bg-amber-950/40' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700' }}">
                <div class="flex items-center justify-between gap-4 border-b border-slate-200/60 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black shadow-md {{ $coming_soon_mode ? 'bg-amber-500 text-slate-950 animate-pulse' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-200' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                        <div>
                            <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                                <span>{{ __('وضع انتظرونا قريباً للمنصة (Coming Soon Mode)') }}</span>
                                @if($coming_soon_mode)
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-slate-950 text-[10px] font-black uppercase tracking-wider animate-pulse">مفعّل حالياً للعموم</span>
                                @endif
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                عند تفعيل هذا الوضع، سيتم تحويل كافة الزوار العموميين إلى شاشة الترقب، مع إمكانية دخول الإدارة عبر الرابط الخاص.
                            </p>
                        </div>
                    </div>

                    {{-- Toggle Switch --}}
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" wire:model.live="coming_soon_mode" class="sr-only peer">
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-slate-600 peer-checked:bg-amber-500"></div>
                    </label>
                </div>

                @if($coming_soon_mode)
                    <div class="pt-5 space-y-4 animate-in fade-in duration-300">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('عنوان شاشة الترقب (Title)') }}</label>
                            <input type="text" wire:model="coming_soon_title" placeholder="انتظرونا قريباً — الإطلاق الرسمي لأولمبياد المهن" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('الرسالة التوضيحية للجمهور (Description)') }}</label>
                            <textarea wire:model="coming_soon_message" rows="3" placeholder="المنصة الوطنية لأولمبياد المهن والمهارات الجزائرية في مرحلة اللمسات الأخيرة والتجهيز النهائي..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-medium text-slate-900 dark:text-white"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-extrabold text-slate-800 dark:text-slate-200 mb-1.5">{{ __('تاريخ وساعة الإطلاق للعداد التنازلي') }}</label>
                                <input type="datetime-local" wire:model="coming_soon_launch_date" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-mono font-bold text-slate-900 dark:text-white">
                            </div>
                            <div class="flex items-end">
                                <a href="{{ route('coming-soon') }}" target="_blank" class="w-full px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition flex items-center justify-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>معاينة صفحة انتظرونا قريباً ↗</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Branding Section -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0V9m0 4h.01M15 9h.01M15 13h.01M11 13h.01M11 17h.01M15 17h.01"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Charte & Identité Visuelle' : (app()->getLocale() === 'en' ? 'Branding & Assets' : 'الهوية البصرية والرموز الرسمية') }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 mb-1.5">{{ __('اسم المنصة الرسمي') }}</label>
                        <input type="text" wire:model="site_name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-brand-500">
                        @error('site_name') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 mb-1.5">{{ __('شعار المنصة (Logo)') }}</label>
                        <input type="file" wire:model="site_logo_file" class="w-full text-xs font-semibold text-slate-600">
                        @error('site_logo_file') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Color Tokens Studio -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Palette de Couleurs (Design Tokens)' : (app()->getLocale() === 'en' ? 'Color Tokens Palette' : 'لوحة الألوان ورموز الهوية') }}</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Brand Colors -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800">{{ __('اللون الرئيسي (Primary)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="primary_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="primary_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800">{{ __('الرئيسي الداكن (Primary Dark)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="primary_dark" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="primary_dark" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800">{{ __('اللون الثانوي (Accent)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="accent_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="accent_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <!-- Status Colors -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-emerald-800">{{ __('لون النجاح (Success)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="success_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="success_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-amber-800">{{ __('لون التنبيه (Warning)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="warning_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="warning_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-rose-800">{{ __('لون الخطر (Danger)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="danger_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="danger_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shape & Border Radius Tokens -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>⭕</span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Rayon de Bordure (Border Radii)' : (app()->getLocale() === 'en' ? 'Border Radius Tokens' : 'درجة انحناء الحواف والأشكال') }}</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Small Radius</label>
                        <select wire:model="radius_sm" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="0">0 (Flat)</option>
                            <option value="0.25rem">0.25rem (4px)</option>
                            <option value="0.375rem">0.375rem (6px)</option>
                            <option value="0.5rem">0.5rem (8px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Medium Radius</label>
                        <select wire:model="radius_md" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="0.5rem">0.5rem (8px)</option>
                            <option value="0.75rem">0.75rem (12px)</option>
                            <option value="1rem">1rem (16px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Large Radius</label>
                        <select wire:model="radius_lg" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="0.75rem">0.75rem (12px)</option>
                            <option value="1rem">1rem (16px)</option>
                            <option value="1.5rem">1.5rem (24px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Extra Large</label>
                        <select wire:model="radius_xl" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="1rem">1rem (16px)</option>
                            <option value="1.5rem">1.5rem (24px)</option>
                            <option value="2rem">2rem (32px)</option>
                            <option value="9999px">Pill (Full Round)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview Sidebar Pane -->
        <div class="lg:col-span-4 space-y-6">
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4 sticky top-6"
                style="--preview-surface: {{ $surface_color }}; --preview-text: {{ $text_color }}; --preview-muted: {{ $muted_text_color }}; --preview-primary: {{ $primary_color }}; --preview-dark: {{ $primary_dark }}; --preview-success: {{ $success_color }}; --preview-warning: {{ $warning_color }}; --preview-danger: {{ $danger_color }}; --preview-radius-md: {{ $radius_md }}; --preview-radius-lg: {{ $radius_lg }}; --preview-radius-xl: {{ $radius_xl }};">
                
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-xs font-black text-slate-500 uppercase tracking-wider flex items-center gap-2">
                        <span>👁️</span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Aperçu en Direct' : (app()->getLocale() === 'en' ? 'Live Preview' : 'المعاينة الحية') }}</span>
                    </h3>
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl text-[10px] font-black">
                        <button wire:click="setPreviewDevice('desktop')" class="px-2 py-0.5 rounded-lg transition {{ $previewDevice === 'desktop' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">🖥️ Desktop</button>
                        <button wire:click="setPreviewDevice('tablet')" class="px-2 py-0.5 rounded-lg transition {{ $previewDevice === 'tablet' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">📱 Tablet</button>
                        <button wire:click="setPreviewDevice('mobile')" class="px-2 py-0.5 rounded-lg transition {{ $previewDevice === 'mobile' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">📲 Mobile</button>
                    </div>
                </div>

                <!-- Live Sample Card -->
                <div class="p-5 rounded-2xl border border-slate-200/80 space-y-4 transition-all duration-300 {{ $previewDevice === 'mobile' ? 'max-w-xs mx-auto' : ($previewDevice === 'tablet' ? 'max-w-md mx-auto' : 'w-full') }}" style="background-color: var(--preview-surface); border-radius: var(--preview-radius-lg);">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black" style="color: var(--preview-text);">{{ $site_name }}</span>
                        <span class="px-2.5 py-1 text-[10px] font-black rounded-full text-white shadow-xs" style="background-color: var(--preview-primary); border-radius: var(--preview-radius-xl);">
                            LIVE PREVIEW
                        </span>
                    </div>

                    <p class="text-xs font-medium leading-relaxed" style="color: var(--preview-muted);">
                        معاينة حية لتنسيق العناصر والبطاقات والألوان الديناميكية على المنصة الوطنية.
                    </p>

                    <div class="flex items-center gap-2">
                        <button class="px-4 py-2 text-xs font-bold text-white shadow-xs" style="background-color: var(--preview-primary); border-radius: var(--preview-radius-md);">
                            {{ __('زر رئيسي') }}
                        </button>
                        <button class="px-4 py-2 text-xs font-bold text-white shadow-xs" style="background-color: var(--preview-dark); border-radius: var(--preview-radius-md);">
                            {{ __('زر ثنائي') }}
                        </button>
                    </div>
                </div>

                <!-- Status Badges Live Preview -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                    <span class="text-[11px] font-extrabold text-slate-600 block">{{ __('معاينة شارات الحالة (Status Badges)') }}</span>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2.5 py-1 text-[10px] font-black text-white rounded-full" style="background-color: var(--preview-success);">اعتماد معتمد</span>
                        <span class="px-2.5 py-1 text-[10px] font-black text-white rounded-full" style="background-color: var(--preview-warning);">قيد التدقيق</span>
                        <span class="px-2.5 py-1 text-[10px] font-black text-white rounded-full" style="background-color: var(--preview-danger);">حالة مرفوضة</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
