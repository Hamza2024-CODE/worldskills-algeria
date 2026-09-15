<div class="space-y-5 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900">إدارة الطعون والشكاوى الفنية</h1>
                <p class="text-sm text-slate-500">إجمالي: <span class="text-blue-600 font-bold">{{ $totalAppeals }}</span> — مفتوحة: <span class="text-amber-600 font-bold">{{ $openAppeals }}</span></p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-xl border border-emerald-200"><x-ws.icon name="check-circle" class="w-4 h-4 inline-block me-1 text-emerald-600" /> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-50 text-red-700 text-sm font-bold rounded-xl border border-red-200"><x-ws.icon name="x-circle" class="w-4 h-4 inline-block me-1 text-red-600" /> {{ session('error') }}</div>
    @endif

    {{-- APPEALS TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-start">الموضوع</th>
                        <th class="px-5 py-3.5 text-start">مقدم الطعن</th>
                        <th class="px-5 py-3.5 text-start">التخصص</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-start">الأولوية</th>
                        <th class="px-5 py-3.5 text-start">التاريخ</th>
                        <th class="px-5 py-3.5 text-end">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($appeals as $appeal)
                        @php
                            $statusColors = [
                                'SUBMITTED'         => 'bg-blue-50 text-blue-700',
                                'ELIGIBILITY_CHECK' => 'bg-indigo-50 text-indigo-700',
                                'UNDER_REVIEW'      => 'bg-amber-50 text-amber-700',
                                'HEARING'           => 'bg-purple-50 text-purple-700',
                                'DECISION_PENDING'  => 'bg-orange-50 text-orange-700',
                                'UPHELD'            => 'bg-emerald-50 text-emerald-700',
                                'REJECTED'          => 'bg-red-50 text-red-700',
                                'PARTIALLY_UPHELD'  => 'bg-teal-50 text-teal-700',
                                'CLOSED'            => 'bg-slate-100 text-slate-500',
                            ];
                            $priorityColors = [
                                'NORMAL' => 'bg-slate-50 text-slate-500',
                                'HIGH'   => 'bg-amber-50 text-amber-700',
                                'URGENT' => 'bg-red-50 text-red-700',
                            ];
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold text-slate-900 max-w-[180px] truncate">{{ $appeal->subject }}</td>
                            <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $appeal->submittedBy?->name ?? '—' }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $appeal->skill?->name_ar ?? '—' }}</td>
                            <td class="px-5 py-3.5"><span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $statusColors[$appeal->status] ?? 'bg-slate-50 text-slate-500' }}">{{ $service->statusLabel($appeal->status) }}</span></td>
                            <td class="px-5 py-3.5"><span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $priorityColors[$appeal->priority] ?? '' }}">{{ $appeal->priority }}</span></td>
                            <td class="px-5 py-3.5 text-xs font-mono text-slate-400">{{ $appeal->submitted_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-5 py-3.5 text-end">
                                <button wire:click="openDrawer({{ $appeal->id }})" class="px-3 py-1 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg">سير الطعن</button>
                                @if(in_array($appeal->status, ['UNDER_REVIEW', 'HEARING']))
                                    <button wire:click="openDecisionModal({{ $appeal->id }})" class="px-3 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg ms-1">إصدار القرار</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400 font-medium">لا توجد طعون فنية مقدمة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appeals->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $appeals->links() }}</div>
        @endif
    </div>

    {{-- APPEAL TIMELINE DRAWER --}}
    @if($drawerOpen && $selected)
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-xs">
            <div class="w-full max-w-lg bg-white border-s border-slate-200 h-full p-6 overflow-y-auto space-y-5 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">سير الطعن الفني</h2>
                        <p class="text-xs font-mono text-slate-400">{{ $selected->appeal_uuid }}</p>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                {{-- Subject & Status --}}
                <div class="bg-slate-50 rounded-xl p-4 space-y-2">
                    <p class="font-black text-slate-900">{{ $selected->subject }}</p>
                    <p class="text-sm text-slate-600">{{ $selected->description }}</p>
                    <div class="flex gap-2 pt-2">
                        @if(!in_array($selected->status, ['UPHELD','REJECTED','PARTIALLY_UPHELD','CLOSED']))
                            @php
                                $nextMap = [
                                    'SUBMITTED'         => ['ELIGIBILITY_CHECK' => 'التحقق من الأهلية'],
                                    'ELIGIBILITY_CHECK' => ['UNDER_REVIEW' => 'بدء الدراسة'],
                                    'UNDER_REVIEW'      => ['HEARING' => 'جلسة استماع', 'DECISION_PENDING' => 'انتظار القرار'],
                                    'HEARING'           => ['DECISION_PENDING' => 'انتظار القرار'],
                                ];
                                $nextOptions = $nextMap[$selected->status] ?? [];
                            @endphp
                            @foreach($nextOptions as $nextStatus => $label)
                                <button wire:click="advanceAppealStatus({{ $selected->id }}, '{{ $nextStatus }}')" class="px-3 py-1 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg">{{ $label }}</button>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="space-y-3">
                    <h3 class="font-black text-sm text-slate-700">سجل التدقيق الثابت (Immutable Audit Trail)</h3>
                    @forelse($selected->events as $event)
                        <div class="flex gap-3">
                            <div class="w-1 bg-blue-100 rounded-full shrink-0 self-stretch"></div>
                            <div class="flex-1 bg-slate-50 rounded-xl p-3">
                                <div class="flex justify-between text-[10px] text-slate-400 font-mono mb-1">
                                    <span>{{ $event->user?->name ?? '—' }}</span>
                                    <span>{{ $event->created_at?->format('Y-m-d H:i:s') }}</span>
                                </div>
                                <p class="text-xs text-slate-700 font-medium">{{ $event->event_details }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">لا توجد أحداث مسجلة بعد.</p>
                    @endforelse
                </div>

                {{-- Decision (if any) --}}
                @if($selected->decision)
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                        <p class="font-black text-emerald-800 text-sm mb-1">القرار النهائي: {{ $selected->decision->decision }}</p>
                        <p class="text-xs text-emerald-700">{{ $selected->decision->reasoning }}</p>
                        <p class="text-[10px] font-mono text-emerald-500 mt-2">{{ $selected->decision->decidedBy?->name }} — {{ $selected->decision->created_at?->format('Y-m-d H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- DECISION MODAL --}}
    @if($decisionModalOpen && $selected)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full space-y-4 border border-slate-200 shadow-xl">
                <h3 class="text-lg font-black text-slate-900">إصدار القرار النهائي</h3>
                <p class="text-sm text-red-600 font-bold"><span class="inline-flex items-center gap-1.5"><x-ws.icon name="exclamation-triangle" class="w-4 h-4 text-red-600 shrink-0" /> القرار ثابت ولا يمكن تعديله أو حذفه بعد الإصدار.</span></p>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">القرار *</label>
                    <select wire:model="decisionValue" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50">
                        <option value="">اختر القرار</option>
                        <option value="UPHELD">مقبول (UPHELD)</option>
                        <option value="REJECTED">مرفوض (REJECTED)</option>
                        <option value="PARTIALLY_UPHELD">مقبول جزئياً (PARTIALLY_UPHELD)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">المبررات والأسباب القانونية *</label>
                    <textarea wire:model="decisionReason" rows="4" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('decisionModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="issueDecision" class="px-5 py-2 text-xs font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs">إصدار القرار النهائي</button>
                </div>
            </div>
        </div>
    @endif

</div>
