<div class="space-y-8">
    <!-- Executive Expert Judge Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0F172A] via-[#1E1B4B] to-[#4338CA] text-white p-6 sm:p-10 shadow-2xl border border-white/10">
        <!-- Subtle Decorative Elements -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative shrink-0">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-tr from-amber-400 via-indigo-400 to-white p-1 shadow-xl overflow-hidden">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full rounded-[14px] object-cover border border-white/20">
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-[#0F172A] flex items-center justify-center text-[10px] text-white shadow-xs" title="حكم أولمبي معتمد"><x-ws.icon name="check" class="w-3.5 h-3.5 text-white" /></span>
                </div>

                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-indigo-500/30 border border-indigo-400/40 text-indigo-200 text-xs font-black tracking-wide flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Juge Expert Officiel' : (app()->getLocale() === 'en' ? 'Official Expert Judge' : 'حكم أولمبي معتمد') }}</span>
                        </span>
                        <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-200 text-xs font-mono font-bold">
                            JUDGE-2026-DZ
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        {{ auth()->user()->name ?? 'حمزه بوبكر الصديق' }}
                    </h1>
                    <p class="text-xs text-amber-200 font-bold">
                        {{ app()->getLocale() === 'fr' ? 'Centre Officiel d\'Évaluation du Jury & Système CIS' : (app()->getLocale() === 'en' ? 'Official Jury Evaluation Center & CIS System' : 'مركز هيئة التحكيم والتقييم الأولمبي الرسمي — نظام التقييم الميداني CIS V9.0') }}
                    </p>
                    <p class="text-xs sm:text-sm text-indigo-200/90 font-bold flex items-center gap-2 pt-1">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Discipline Assignée: ' : (app()->getLocale() === 'en' ? 'Assigned Skill Trade: ' : 'التخصص التنافسي المسند للحكم: ') }}</span>
                        <strong class="text-amber-300 font-extrabold">{{ $assignedSkills->pluck('name_ar')->implode(' / ') }}</strong>
                    </p>
                </div>
            </div>

            <!-- Quick Action Judge Badge Pass Button -->
            <div class="flex items-center gap-3 self-start md:self-auto">
                <a href="{{ route('my.badge') }}" target="_blank" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-xs shadow-xl shadow-amber-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Afficher Badge du Juge' : (app()->getLocale() === 'en' ? 'View Judge Badge' : 'عرض شارة الاعتماد للحكم ↗') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Notification Message -->
    @if($evalSuccessMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $evalSuccessMessage }}</span>
            </div>
            <button type="button" wire:click="$set('evalSuccessMessage', '')" class="text-emerald-600 hover:text-emerald-900 font-black text-xs"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
        </div>
    @endif

    <!-- Operational KPI Stat Cards Grid (4 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Assigned Competitors for Judge's Skill -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-md space-y-2 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'fr' ? 'Candidats du Métier' : (app()->getLocale() === 'en' ? 'Skill Competitors' : 'متنافسو التخصص المسند') }}</span>
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-[#06205C]">{{ $totalCount }}</p>
            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full inline-block">
                {{ app()->getLocale() === 'fr' ? 'Dans votre discipline' : (app()->getLocale() === 'en' ? 'In your skill trade' : 'في تخصصك التنافسي') }}
            </span>
        </div>

        <!-- Completed CIS Evaluations -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-md space-y-2 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'fr' ? 'Évaluations Validées' : (app()->getLocale() === 'en' ? 'Evaluated CIS Scores' : 'التقييمات المكتملة') }}</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-emerald-600">{{ $evaluatedCount }}</p>
            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full inline-block">
                {{ app()->getLocale() === 'fr' ? 'Résultats Consignés' : (app()->getLocale() === 'en' ? 'Recorded Scores' : 'درجات موثقة بالنظام') }}
            </span>
        </div>

        <!-- Pending Evaluations -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-md space-y-2 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'Pending Assessments' : 'قيد الانتظار') }}</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-amber-600">{{ $pendingCount }}</p>
            <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2.5 py-0.5 rounded-full inline-block">
                {{ app()->getLocale() === 'fr' ? 'À Évaluer sur le Terrain' : (app()->getLocale() === 'en' ? 'To Evaluate' : 'في انتظار التحكيم') }}
            </span>
        </div>

        <!-- Assigned Trade Skills -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-md space-y-2 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ app()->getLocale() === 'fr' ? 'Discipline Assignée' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'التخصص المسند') }}</span>
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
            </div>
            <p class="text-lg font-black text-purple-700 truncate">{{ $assignedSkills->pluck('name_ar')->first() }}</p>
            <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2.5 py-0.5 rounded-full inline-block">
                {{ app()->getLocale() === 'fr' ? 'Exclusivité du Jury' : (app()->getLocale() === 'en' ? 'Jury Specialization' : 'تحكيم خاص بالتخصص') }}
            </span>
        </div>
    </div>

    <!-- Filter Bar & Search -->
    <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="text-xs font-black text-slate-700">التخصص المسند للحكم:</span>
            @foreach($assignedSkills as $sk)
                <span class="px-4 py-2 rounded-2xl text-xs font-black bg-[#0066FF] text-white shadow-md flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span>
                    <span>{{ $sk->getLocalized('name') }}</span>
                </span>
            @endforeach
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher par nom, code...' : (app()->getLocale() === 'en' ? 'Search name, code...' : 'ابحث باسم المتنافس أو رمزه...') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-[#0066FF] outline-hidden">
        </div>
    </div>

    <!-- Competitors Evaluation Data Table -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-[#0066FF]"></span>
                <h3 class="text-base font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Candidats du Métier Assigné pour Évaluation CIS' : (app()->getLocale() === 'en' ? 'Assigned Skill Trade Competitors' : 'جدول متنافسي التخصص المسند للحكم للتقييم الميداني') }}
                </h3>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-50 text-[#0066FF] border border-blue-200">
                {{ count($approvedParticipants) }} {{ app()->getLocale() === 'fr' ? 'candidats' : 'متنافسين' }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right dir-rtl">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-extrabold text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Compétiteur' : (app()->getLocale() === 'en' ? 'Competitor' : 'المتنافس') }}</th>
                        <th class="px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Code Officiel' : (app()->getLocale() === 'en' ? 'Official Code' : 'رمز التسجيل') }}</th>
                        <th class="px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Discipline' : (app()->getLocale() === 'en' ? 'Skill Trade' : 'التخصص التنافسي') }}</th>
                        <th class="px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Délégation / Wilaya' : (app()->getLocale() === 'en' ? 'Delegation / Wilaya' : 'الوفد / المؤسسة') }}</th>
                        <th class="px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Statut CIS' : (app()->getLocale() === 'en' ? 'CIS Status & Score' : 'حالة التقييم والدرجة') }}</th>
                        <th class="px-6 py-4 text-center">{{ app()->getLocale() === 'fr' ? 'Actions Jury' : (app()->getLocale() === 'en' ? 'Jury Actions' : 'إجراءات التحكيم') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($approvedParticipants as $cand)
                        @php
                            $evalData = $evaluations[$cand->id] ?? null;
                            $candName = $cand->participant?->first_name_ar ? ($cand->participant->first_name_ar . ' ' . $cand->participant->last_name_ar) : ($cand->user?->name ?? 'متنافس معتمد');
                            $photoUrl = $cand->participant?->photo_path ? asset('storage/' . ltrim($cand->participant->photo_path, '/')) : ($cand->user?->avatar_url ?? null);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                        @if($photoUrl)
                                            <img src="{{ $photoUrl }}" alt="{{ $candName }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center font-black text-slate-600 bg-slate-200">
                                                {{ mb_substr($candName, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 text-sm">{{ $candName }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold">{{ $cand->participant?->email ?? $cand->user?->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 font-mono font-black text-[#0066FF]">
                                <span class="px-2.5 py-1 rounded-xl bg-blue-50 border border-blue-100">
                                    {{ $cand->registration_number ?? ('CND-'.str_pad($cand->id, 5, '0', STR_PAD_LEFT)) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 font-extrabold text-slate-800">
                                {{ $cand->skill?->getLocalized('name') ?? 'Cyber Security' }}
                            </td>

                            <td class="px-6 py-4 font-bold text-slate-600">
                                <span>{{ $cand->country?->getLocalized('name') ?? $cand->participant?->wilaya?->name_ar ?? 'الوفد الوطني' }}</span>
                            </td>

                            <td class="px-6 py-4">
                                @if($evalData)
                                    <div class="space-y-1">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300 inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ app()->getLocale() === 'fr' ? 'Évalué:' : (app()->getLocale() === 'en' ? 'Evaluated:' : 'تم التقييم:') }} {{ $evalData['total'] }} / 30.0</span>
                                        </span>
                                        <p class="text-[9px] text-slate-400 font-mono">{{ $evalData['evaluated_at'] }}</p>
                                    </div>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[11px] font-black bg-amber-50 text-amber-700 border border-amber-200 inline-block">
                                        {{ app()->getLocale() === 'fr' ? 'En attente d\'évaluation' : (app()->getLocale() === 'en' ? 'Pending Assessment' : 'في انتظار التحكيم والتقييم') }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEvaluation({{ $cand->id }})" type="button" class="px-4 py-2 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $evalData ? (app()->getLocale() === 'fr' ? 'Modifier Note' : (app()->getLocale() === 'en' ? 'Edit Score' : 'تعديل التقييم')) : (app()->getLocale() === 'fr' ? 'Évaluer Candidat' : (app()->getLocale() === 'en' ? 'Grade Candidate' : 'تقييم المتنافس')) }}</span>
                                    </button>

                                    <button wire:click="viewCandidateInfo({{ $cand->id }})" type="button" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-1">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ app()->getLocale() === 'fr' ? 'Fiche Candidat' : (app()->getLocale() === 'en' ? 'View Dossier' : 'معلومات المتربص') }}</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-xs font-bold text-slate-400">
                                {{ app()->getLocale() === 'fr' ? 'Aucun candidat trouvé pour ce métier' : (app()->getLocale() === 'en' ? 'No candidates found for this assigned trade' : 'لا يوجد متنافسون مسندون لهذا التخصص حالياً.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- POPUP MODAL: CLEAN CANDIDATE DOSSIER INFO (WITHOUT BADGE INSIDE MODAL) -->
    @if($showViewCandidateModal && $viewingCandidate)
        @php
            $p = $viewingCandidate->participant;
            $u = $viewingCandidate->user;
            $candName = $p?->first_name_ar ? ($p->first_name_ar . ' ' . $p->last_name_ar) : ($u?->name ?? 'المتربص');
            $regNum = $viewingCandidate->registration_number ?? $viewingCandidate->uuid;
        @endphp
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" x-cloak>
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-5 shadow-2xl border border-slate-200 text-right relative overflow-hidden" @click.away="closeCandidateInfo">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#0066FF]"></span>
                        <h3 class="text-base font-black text-[#06205C]">
                            {{ app()->getLocale() === 'fr' ? 'Fiche d\'Information du Candidat / Mètrebess' : (app()->getLocale() === 'en' ? 'Candidate Information Sheet' : 'معلومات ملف المتربص التوصيفية') }}
                        </h3>
                    </div>
                    <button wire:click="closeCandidateInfo" type="button" class="text-slate-400 hover:text-slate-700 font-bold text-sm"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <!-- Candidate Profile Header Card -->
                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <div class="w-16 h-16 rounded-2xl bg-[#06205C] text-white font-black flex items-center justify-center text-xl overflow-hidden shadow-md shrink-0">
                        @if($p?->photo_path)
                            <img src="{{ asset('storage/' . ltrim($p->photo_path, '/')) }}" alt="{{ $candName }}" class="w-full h-full object-cover">
                        @else
                            {{ mb_substr($candName, 0, 1) }}
                        @endif
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-black text-slate-900">{{ $candName }}</h4>
                        <p class="text-xs font-mono font-bold text-[#0066FF]">{{ $regNum }}</p>
                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold border border-emerald-200">
                            {{ $viewingCandidate->status->value ?? $viewingCandidate->status }}
                        </span>
                    </div>
                </div>

                <!-- Clean Information Details Grid -->
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px] font-bold">التخصص التنافسي المسند</span>
                        <strong class="text-slate-900 block font-bold mt-0.5">{{ $viewingCandidate->skill?->getLocalized('name') ?? '—' }}</strong>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px] font-bold">الوفد / الولاية</span>
                        <strong class="text-slate-900 block font-bold mt-0.5">{{ $viewingCandidate->country?->getLocalized('name') ?? $p?->wilaya?->name_ar ?? 'الوفد الوطني' }}</strong>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px] font-bold">البريد الإلكتروني</span>
                        <strong class="text-slate-900 block font-mono font-bold truncate mt-0.5">{{ $u?->email ?? $p?->email ?? '—' }}</strong>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px] font-bold">رقم الهاتف</span>
                        <strong class="text-slate-900 block font-mono font-bold mt-0.5">{{ $p?->phone ?? '—' }}</strong>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px] font-bold">رقم بطاقة الهوية (NIN)</span>
                        <strong class="text-slate-900 block font-mono font-bold mt-0.5">{{ $p?->national_id ?? 'غير مدخل' }}</strong>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px] font-bold">رقم جواز السفر</span>
                        <strong class="text-slate-900 block font-mono font-bold mt-0.5">{{ $p?->passport_number ?? 'غير مدخل' }}</strong>
                    </div>

                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 col-span-2">
                        <span class="text-slate-400 block text-[10px] font-bold">المؤسسة التكوينية والمقر</span>
                        <strong class="text-slate-900 block font-bold mt-0.5">{{ $p?->organization?->name_ar ?? 'مؤسسة التكوين والتعليم المهني المعتمدة' }}</strong>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-3 flex items-center justify-end border-t border-slate-100">
                    <button wire:click="closeCandidateInfo" type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">
                        {{ app()->getLocale() === 'fr' ? 'Fermer' : (app()->getLocale() === 'en' ? 'Close' : 'إغلاق') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- CIS Scoring Assessment Modal / Drawer -->
    @if($showEvalModal && $selectedCandidate)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" x-cloak>
            <div class="bg-white rounded-3xl max-w-xl w-full p-6 space-y-6 shadow-2xl border border-slate-200 relative overflow-hidden" @click.away="closeEvaluation">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <h3 class="text-base font-black text-[#06205C]">
                            {{ app()->getLocale() === 'fr' ? 'Grille d\'Évaluation CIS WorldSkills V9.0' : (app()->getLocale() === 'en' ? 'CIS WorldSkills V9.0 Assessment Matrix' : 'مصفوفة تقييم المتنافس (نظام CIS WorldSkills V9.0)') }}
                        </h3>
                    </div>
                    <button wire:click="closeEvaluation" type="button" class="text-slate-400 hover:text-slate-700 font-bold text-sm"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <!-- Competitor Mini Header -->
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-between gap-3">
                    <div>
                        <h4 class="text-sm font-black text-[#06205C]">
                            {{ $selectedCandidate->participant?->first_name_ar ? ($selectedCandidate->participant->first_name_ar . ' ' . $selectedCandidate->participant->last_name_ar) : ($selectedCandidate->user?->name ?? 'المتنافس') }}
                        </h4>
                        <p class="text-xs font-mono font-bold text-[#0066FF] mt-0.5">
                            {{ $selectedCandidate->registration_number ?? ('CND-'.$selectedCandidate->id) }} — {{ $selectedCandidate->skill?->getLocalized('name') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-white text-[#0066FF] font-black text-xs border border-blue-200 shadow-xs">
                        {{ $selectedCandidate->country?->getLocalized('name') ?? 'الوفد الوطني' }}
                    </span>
                </div>

                <!-- 3 Criteria Input Controls -->
                <div class="space-y-4">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-black text-slate-800">
                                {{ app()->getLocale() === 'fr' ? 'Module A: Maîtrise Technique & Précision (0 - 10)' : (app()->getLocale() === 'en' ? 'Module A: Technical Precision & Skill (0 - 10)' : 'المعيار الأول: الدقة والمهارة الفنية (0 - 10)') }}
                            </label>
                            <span class="text-xs font-black text-[#0066FF]">{{ $criterion1 }} / 10</span>
                        </div>
                        <input type="range" step="0.5" min="0" max="10" wire:model.live="criterion1" class="w-full accent-[#0066FF]">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-black text-slate-800">
                                {{ app()->getLocale() === 'fr' ? 'Module B: Rapidité & Normes HSE / Sécurité (0 - 10)' : (app()->getLocale() === 'en' ? 'Module B: Speed & HSE Safety Standards (0 - 10)' : 'المعيار الثاني: السرعة ومعايير الأمان والسلامة (0 - 10)') }}
                            </label>
                            <span class="text-xs font-black text-amber-600">{{ $criterion2 }} / 10</span>
                        </div>
                        <input type="range" step="0.5" min="0" max="10" wire:model.live="criterion2" class="w-full accent-amber-500">
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-black text-slate-800">
                                {{ app()->getLocale() === 'fr' ? 'Module C: Innovation & Qualité Finale (0 - 10)' : (app()->getLocale() === 'en' ? 'Module C: Innovation & Final Finish Quality (0 - 10)' : 'المعيار الثالث: الابتكار والجودة الشاملة (0 - 10)') }}
                            </label>
                            <span class="text-xs font-black text-purple-600">{{ $criterion3 }} / 10</span>
                        </div>
                        <input type="range" step="0.5" min="0" max="10" wire:model.live="criterion3" class="w-full accent-purple-600">
                    </div>

                    <!-- Total Live Calculation -->
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs font-black text-emerald-900">
                        <span>{{ app()->getLocale() === 'fr' ? 'Score Total Calculé:' : (app()->getLocale() === 'en' ? 'Calculated Total Score:' : 'النتيجة الملاحظة الإجمالية:') }}</span>
                        <span class="text-base font-mono font-black text-emerald-700">{{ round($criterion1 + $criterion2 + $criterion3, 2) }} / 30.00</span>
                    </div>

                    <!-- Judge Technical Observations -->
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700">
                            {{ app()->getLocale() === 'fr' ? 'Observations & Remarques du Juge' : (app()->getLocale() === 'en' ? 'Judge Technical Observations' : 'ملاحظات وتوصيات هيئة التحكيم الفنية') }}
                        </label>
                        <textarea wire:model="judgeNotes" rows="2" placeholder="{{ app()->getLocale() === 'fr' ? 'Ajouter des remarques techniques...' : (app()->getLocale() === 'en' ? 'Add technical observations...' : 'أضف ملاحظات تحكيمية تفصيلية...') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-[#0066FF] outline-hidden"></textarea>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button wire:click="closeEvaluation" type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">
                        {{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}
                    </button>
                    <button wire:click="submitEvaluation" type="button" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Valider Note Officielle' : (app()->getLocale() === 'en' ? 'Save Verified Score' : 'اعتماد وتوثيق النتيجة الرسمية') }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
