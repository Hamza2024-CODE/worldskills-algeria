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
            
            <!-- Branding Section -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🏛️</span>
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
                    <span>🌈</span>
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
