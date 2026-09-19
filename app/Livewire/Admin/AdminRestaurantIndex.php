<?php

namespace App\Livewire\Admin;

use App\Models\Badge;
use App\Models\Country;
use App\Models\DelegationMember;
use App\Models\MealEntitlement;
use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\Rules\WsapAccessRulesEngine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminRestaurantIndex extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $activeTab    = 'scanner'; // scanner | restaurants | slots | entitlements | scans
    public string $search       = '';
    public string $filterDate   = '';
    public string $filterMeal   = '';
    public string $filterStatus = '';

    // ── Live Scanner ──────────────────────────────────────────
    public string $scanQuery           = '';
    public ?int   $selectedSlotId      = null;
    public array  $scanResult          = [];
    public bool   $scanResultModalOpen = false;

    // ── Restaurant Form ───────────────────────────────────────
    public bool   $restaurantFormOpen = false;
    public bool   $restaurantEditing  = false;
    public ?int   $restaurantEditId   = null;

    public string $name_ar       = '';
    public string $name_fr       = '';
    public string $name_en       = '';
    public string $location      = '';
    public string $contact_phone = '';
    public int    $capacity      = 300;
    public bool   $is_active     = true;
    public string $notes_r       = '';

    // ── Meal Slot Form ────────────────────────────────────────
    public bool   $slotFormOpen       = false;
    public bool   $slotEditing        = false;
    public ?int   $slotEditId         = null;
    public ?int   $slot_restaurant_id = null;
    public string $slot_date          = '';
    public string $slot_meal_type     = 'LUNCH';
    public string $slot_start         = '12:00';
    public string $slot_end           = '14:30';
    public int    $slot_capacity      = 300;
    public bool   $slot_is_open       = true;
    public string $slot_notes         = '';

    // ── Entitlement Form ──────────────────────────────────────
    public bool   $entitlementFormOpen = false;
    public ?int   $ent_meal_slot_id    = null;
    public string $ent_assign_type     = 'delegation'; // user | delegation
    public ?int   $ent_user_id         = null;
    public ?int   $ent_country_id      = null;

    // ── Delete confirmation ───────────────────────────────────
    public bool   $deleteOpen       = false;
    public ?int   $deleteTargetId  = null;
    public string $deleteTargetType = '';

    // ── Flash ─────────────────────────────────────────────────
    public string $flashMessage = '';
    public string $flashType    = 'success';

    public function mount(): void
    {
        $this->filterDate = today()->toDateString();

        $firstOpen = MealSlot::where('is_open', true)
            ->whereDate('date', today())
            ->first();

        if ($firstOpen) {
            $this->selectedSlotId = $firstOpen->id;
        } else {
            $latestSlot = MealSlot::whereDate('date', today())->first() ?? MealSlot::latest()->first();
            if ($latestSlot) {
                $this->selectedSlotId = $latestSlot->id;
            }
        }
    }

    public function updatedActiveTab(): void
    {
        $this->resetPage();
    }

    public function updatedFilterDate(): void
    {
        $this->resetPage();
    }

    public function updatedFilterMeal(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    // ────────────────────────────────────────────────────────
    // LIVE SCANNER METHOD
    // ────────────────────────────────────────────────────────
    public function scanMealBadge(?string $code = null): void
    {
        $token = trim($code ?? $this->scanQuery);
        if (empty($token)) {
            return;
        }

        // Determine target slot
        $slot = null;
        if ($this->selectedSlotId) {
            $slot = MealSlot::with('restaurant')->find($this->selectedSlotId);
        }

        if (!$slot) {
            $slot = MealSlot::with('restaurant')
                ->where('is_open', true)
                ->whereDate('date', today())
                ->orderBy('start_time')
                ->first();
        }

        if (!$slot) {
            $this->scanResult = [
                'status'        => 'DENIED',
                'title'         => 'لا توجد خانة وجبة مفتوحة',
                'message'       => 'يرجى تفعيل أو تحديد خانة وجبة مفتوحة اليوم أولاً.',
                'user'          => null,
                'badge'         => null,
                'slot'          => null,
                'dietary_list'  => [],
                'dietary_notes' => '',
                'scanned_at'    => now()->format('H:i:s'),
            ];
            $this->scanResultModalOpen = true;
            $this->scanQuery = '';
            return;
        }

        // Lookup Badge & User
        $badge = null;
        $user  = null;

        // Strategy 1: Search Badge by badge_uuid, barcode_hash, or id
        $badge = Badge::with(['user.country', 'user.participant.registrations', 'user'])
            ->where(function ($q) use ($token) {
                $q->where('badge_uuid', $token)
                  ->orWhere('access_token', $token);
                if (ctype_digit($token)) {
                    $q->orWhere('id', (int) $token);
                }
            })
            ->first();

        if ($badge && $badge->user) {
            $user = $badge->user;
        }

        // Strategy 2: Search User directly if not matched via Badge
        if (!$user) {
            $user = User::with(['country', 'participant.registrations', 'dietaryRequirements', 'badge'])
                ->where(function ($q) use ($token) {
                    $q->where('email', $token)
                      ->orWhere('name', $token);
                    if (ctype_digit($token)) {
                        $q->orWhere('id', (int) $token);
                    }
                })
                ->orWhereHas('participant', function ($pq) use ($token) {
                    $pq->where('national_id', $token)
                       ->orWhere('passport_number', $token);
                })
                ->orWhereHas('participant.registrations', function ($rq) use ($token) {
                    $rq->where('registration_number', $token)->orWhere('verification_token', $token)->orWhere('uuid', $token);
                })
                ->first();

            if ($user && $user->badge) {
                $badge = $user->badge;
            }
        }

        // Gather Dietary Info
        $dietaryList  = [];
        $dietaryNotes = '';

        if ($user) {
            $dm = DelegationMember::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();
            if ($dm) {
                $dietaryList  = is_array($dm->dietary_requirements) ? $dm->dietary_requirements : [];
                $dietaryNotes = $dm->dietary_notes ?? '';
            }
            if (empty($dietaryList) && is_array($user->dietary_requirements ?? null)) {
                $dietaryList = $user->dietary_requirements;
            }
            if (empty($dietaryNotes) && !empty($user->notes)) {
                $dietaryNotes = $user->notes;
            }
        }

        // Unknown token case
        if (!$user && !$badge) {
            MealScan::create([
                'meal_slot_id'              => $slot->id,
                'user_id'                   => null,
                'scanned_by_user_id'        => Auth::id(),
                'badge_code'                => $token,
                'status'                    => 'DENIED',
                'denial_reason'             => 'رمز الشارة غير معروف في النظام',
                'participant_name_snapshot' => 'غير معروف',
                'country_snapshot'          => 'غير معروف',
                'restaurant_snapshot'       => $slot->restaurant?->name_ar ?? 'مطعم غير محدد',
                'meal_type_snapshot'        => $slot->meal_type,
                'scanned_at'                 => now(),
            ]);

            $this->scanResult = [
                'status'        => 'DENIED',
                'title'         => 'رمز غير معروف',
                'message'       => 'لم يتم العثور على شارة أو مشارك مسجل بهذا الرمز (' . $token . ').',
                'user'          => null,
                'badge'         => null,
                'slot'          => $slot,
                'dietary_list'  => [],
                'dietary_notes' => '',
                'scanned_at'    => now()->format('H:i:s'),
            ];

            $this->scanResultModalOpen = true;
            $this->scanQuery = '';
            return;
        }

        // Check duplicate scan for this user and slot
        $alreadyScanned = MealScan::where('meal_slot_id', $slot->id)
            ->where('user_id', $user->id)
            ->where('status', 'AUTHORIZED')
            ->orderByDesc('scanned_at')
            ->first();

        if ($alreadyScanned) {
            MealScan::create([
                'meal_slot_id'              => $slot->id,
                'user_id'                   => $user->id,
                'scanned_by_user_id'        => Auth::id(),
                'badge_code'                => $badge?->badge_uuid ?? $token,
                'status'                    => 'DUPLICATE',
                'denial_reason'             => 'تم استهلاك الوجبة سابقاً في ' . $alreadyScanned->scanned_at?->format('H:i'),
                'participant_name_snapshot' => $user->name,
                'country_snapshot'          => $user->country?->name_ar ?? $user->country?->name_en ?? 'N/A',
                'restaurant_snapshot'       => $slot->restaurant?->name_ar ?? 'مطعم غير محدد',
                'meal_type_snapshot'        => $slot->meal_type,
                'scanned_at'                 => now(),
            ]);

            $this->scanResult = [
                'status'        => 'DUPLICATE',
                'title'         => 'الوجبة مسجلة مسبقاً (مكرر)',
                'message'       => 'تم تقديم هذه الوجبة بالفعل للمشارك في هذه الفتحة الزمنيّة اليوم في الساعة ' . $alreadyScanned->scanned_at?->format('H:i:s') . '.',
                'user'          => $user,
                'badge'         => $badge,
                'slot'          => $slot,
                'dietary_list'  => $dietaryList,
                'dietary_notes' => $dietaryNotes,
                'scanned_at'    => now()->format('H:i:s'),
            ];

            $this->scanResultModalOpen = true;
            $this->scanQuery = '';
            return;
        }

        // Evaluate access with WsapAccessRulesEngine
        if ($badge) {
            $accessEngine = app(WsapAccessRulesEngine::class);
            $decision = $accessEngine->evaluateAccess($badge, null, 'MEAL_SLOT', (string) $slot->id, (string) Auth::id());
            $isAllowed = $decision['is_allowed'];
            $reasonAr  = $decision['message_ar'] ?? ($isAllowed ? 'مصرح بالوجبة' : 'غير مصرح');
        } else {
            $countryId = $user->country_id ?: $user->participant?->registrations?->first()?->country_id;
            $hasEntitlement = MealEntitlement::where('meal_slot_id', $slot->id)
                ->where(function ($q) use ($user, $countryId) {
                    $q->where('user_id', $user->id);
                    if ($countryId) {
                        $q->orWhere('country_id', $countryId);
                    }
                })
                ->exists();

            $isAllowed = $hasEntitlement && $slot->is_open;
            $reasonAr  = $isAllowed ? 'مصرح بالوجبة' : ($hasEntitlement ? 'الخانة مغلقة' : 'لا يملك استحقاق وجبة في هذا المطعم');
        }

        $status = $isAllowed ? 'AUTHORIZED' : 'DENIED';

        MealScan::create([
            'meal_slot_id'              => $slot->id,
            'user_id'                   => $user->id,
            'scanned_by_user_id'        => Auth::id(),
            'badge_code'                => $badge?->badge_uuid ?? $token,
            'status'                    => $status,
            'denial_reason'             => $isAllowed ? null : $reasonAr,
            'participant_name_snapshot' => $user->name,
            'country_snapshot'          => $user->country?->name_ar ?? $user->country?->name_en ?? 'N/A',
            'restaurant_snapshot'       => $slot->restaurant?->name_ar ?? 'مطعم غير محدد',
            'meal_type_snapshot'        => $slot->meal_type,
            'scanned_at'                 => now(),
        ]);

        $this->scanResult = [
            'status'        => $status,
            'title'         => $isAllowed ? 'تمت المصادقة — تفضل بالدخول' : 'تم الرفض — غير مصرح',
            'message'       => $reasonAr,
            'user'          => $user,
            'badge'         => $badge,
            'slot'          => $slot,
            'dietary_list'  => $dietaryList,
            'dietary_notes' => $dietaryNotes,
            'scanned_at'    => now()->format('H:i:s'),
        ];

        $this->scanResultModalOpen = true;
        $this->scanQuery = '';
    }

    public function overrideScan(int $userId, int $slotId): void
    {
        $slot = MealSlot::with('restaurant')->findOrFail($slotId);
        $user = User::with('country')->findOrFail($userId);

        MealScan::create([
            'meal_slot_id'              => $slot->id,
            'user_id'                   => $user->id,
            'scanned_by_user_id'        => Auth::id(),
            'badge_code'                => $user->badge?->badge_uuid ?? 'MANUAL_OVERRIDE',
            'status'                    => 'AUTHORIZED',
            'denial_reason'             => 'تجاوز واستثناء يدوي مصرح به من المشرف',
            'participant_name_snapshot' => $user->name,
            'country_snapshot'          => $user->country?->name_ar ?? $user->country?->name_en ?? 'N/A',
            'restaurant_snapshot'       => $slot->restaurant?->name_ar ?? 'مطعم غير محدد',
            'meal_type_snapshot'        => $slot->meal_type,
            'scanned_at'                 => now(),
        ]);

        $this->scanResult['status']  = 'AUTHORIZED';
        $this->scanResult['title']   = 'تم منح الاستثناء المصرح';
        $this->scanResult['message'] = 'تمت الموافقة الاستثنائية وتدوين الوجبة كاستهلاك مصرح به.';

        $this->flash('تم منح استثناء استثنائي للمشارك وتسجيل الوجبة بنجاح.');
    }

    public function closeScanModal(): void
    {
        $this->scanResultModalOpen = false;
        $this->scanResult = [];
    }

    // ────────────────────────────────────────────────────────
    // RESTAURANT CRUD
    // ────────────────────────────────────────────────────────
    public function openRestaurantForm(?int $id = null): void
    {
        $this->resetRestaurantForm();
        $this->restaurantFormOpen = true;

        if ($id) {
            $r = Restaurant::findOrFail($id);
            $this->restaurantEditing  = true;
            $this->restaurantEditId   = $id;
            $this->name_ar            = $r->name_ar;
            $this->name_fr            = $r->name_fr ?? '';
            $this->name_en            = $r->name_en ?? '';
            $this->location           = $r->location ?? '';
            $this->contact_phone      = $r->contact_phone ?? '';
            $this->capacity           = $r->capacity;
            $this->is_active          = $r->is_active;
            $this->notes_r            = $r->notes ?? '';
        }
    }

    public function saveRestaurant(): void
    {
        $this->validate([
            'name_ar'  => 'required|min:2|max:100',
            'capacity' => 'required|integer|min:1|max:99999',
        ], [
            'name_ar.required'  => 'اسم المطعم بالعربية مطلوب.',
            'capacity.required' => 'الطاقة الاستيعابية مطلوبة.',
        ]);

        $data = [
            'name_ar'       => $this->name_ar,
            'name_fr'       => $this->name_fr ?: null,
            'name_en'       => $this->name_en ?: null,
            'location'      => $this->location ?: null,
            'contact_phone' => $this->contact_phone ?: null,
            'capacity'      => $this->capacity,
            'is_active'     => $this->is_active,
            'notes'         => $this->notes_r ?: null,
        ];

        if ($this->restaurantEditing) {
            Restaurant::findOrFail($this->restaurantEditId)->update($data);
            $this->flash('تم تحديث بيانات المطعم بنجاح.');
        } else {
            Restaurant::create(array_merge($data, ['uuid' => (string) Str::uuid()]));
            $this->flash('تمت إضافة المطعم الجديد بنجاح.');
        }

        $this->restaurantFormOpen = false;
        $this->resetRestaurantForm();
    }

    // ────────────────────────────────────────────────────────
    // MEAL SLOT CRUD
    // ────────────────────────────────────────────────────────
    public function openSlotForm(?int $restaurantId = null, ?int $slotId = null): void
    {
        $this->resetSlotForm();
        $this->slotFormOpen = true;
        $this->slot_restaurant_id = $restaurantId;

        if ($slotId) {
            $s = MealSlot::findOrFail($slotId);
            $this->slotEditing          = true;
            $this->slotEditId           = $slotId;
            $this->slot_restaurant_id   = $s->restaurant_id;
            $this->slot_date            = $s->date ? $s->date->toDateString() : today()->toDateString();
            $this->slot_meal_type       = $s->meal_type;
            $this->slot_start           = $s->start_time;
            $this->slot_end             = $s->end_time;
            $this->slot_capacity        = $s->max_capacity;
            $this->slot_is_open         = $s->is_open;
            $this->slot_notes           = $s->notes ?? '';
        }
    }

    public function saveSlot(): void
    {
        $this->validate([
            'slot_restaurant_id' => 'required|exists:restaurants,id',
            'slot_date'          => 'required|date',
            'slot_meal_type'     => 'required|in:BREAKFAST,LUNCH,DINNER,SNACK',
            'slot_start'         => 'required',
            'slot_end'           => 'required',
            'slot_capacity'      => 'required|integer|min:1',
        ], [
            'slot_restaurant_id.required' => 'يجب اختيار مطعم.',
            'slot_date.required'          => 'يجب اختيار تاريخ الوجبة.',
            'slot_meal_type.required'     => 'يجب اختيار نوع الوجبة.',
        ]);

        $data = [
            'restaurant_id' => $this->slot_restaurant_id,
            'date'          => $this->slot_date,
            'meal_type'     => $this->slot_meal_type,
            'start_time'    => $this->slot_start,
            'end_time'      => $this->slot_end,
            'max_capacity'  => $this->slot_capacity,
            'is_open'       => $this->slot_is_open,
            'notes'         => $this->slot_notes ?: null,
        ];

        if ($this->slotEditing) {
            MealSlot::findOrFail($this->slotEditId)->update($data);
            $this->flash('تم تحديث خانة الوجبة بنجاح.');
        } else {
            $slot = MealSlot::create(array_merge($data, ['uuid' => (string) Str::uuid()]));
            $this->selectedSlotId = $slot->id;
            $this->flash('تمت إضافة خانة الوجبة بنجاح.');
        }

        $this->slotFormOpen = false;
        $this->resetSlotForm();
        $this->resetPage();
    }

    public function toggleSlotStatus(int $id): void
    {
        $slot = MealSlot::findOrFail($id);
        $slot->update(['is_open' => !$slot->is_open]);
        $this->flash($slot->is_open ? 'تم فتح الخانة للمسح.' : 'تم إغلاق الخانة.');
    }

    public function grantEntitlementToAllDelegations(int $slotId): void
    {
        $slot = MealSlot::findOrFail($slotId);
        $countries = Country::where('is_active', true)->get();
        $added = 0;

        foreach ($countries as $country) {
            $exists = MealEntitlement::where('meal_slot_id', $slotId)
                ->where('country_id', $country->id)
                ->exists();

            if (!$exists) {
                MealEntitlement::create([
                    'uuid'          => (string) Str::uuid(),
                    'meal_slot_id'  => $slotId,
                    'restaurant_id' => $slot->restaurant_id,
                    'country_id'    => $country->id,
                    'status'        => 'ACTIVE',
                    'created_by'    => Auth::id(),
                ]);
                $added++;
            }
        }

        $this->flash("تم منح استحقاق الوجبة لجميع الوفود ({$added} وفد).");
    }

    // ────────────────────────────────────────────────────────
    // ENTITLEMENT CRUD
    // ────────────────────────────────────────────────────────
    public function openEntitlementForm(?int $slotId = null): void
    {
        $this->ent_meal_slot_id    = $slotId ?: MealSlot::where('is_open', true)->first()?->id;
        $this->ent_assign_type     = 'delegation';
        $this->ent_user_id         = null;
        $this->ent_country_id      = null;
        $this->entitlementFormOpen = true;
    }

    public function saveEntitlement(): void
    {
        $this->validate([
            'ent_meal_slot_id' => 'required|exists:meal_slots,id',
            'ent_assign_type'  => 'required|in:user,delegation',
        ]);

        $slot = MealSlot::findOrFail($this->ent_meal_slot_id);

        if ($this->ent_assign_type === 'delegation') {
            $this->validate(['ent_country_id' => 'required|exists:countries,id']);

            $exists = MealEntitlement::where('meal_slot_id', $this->ent_meal_slot_id)
                ->where('country_id', $this->ent_country_id)
                ->exists();

            if (!$exists) {
                MealEntitlement::create([
                    'uuid'          => (string) Str::uuid(),
                    'meal_slot_id'  => $this->ent_meal_slot_id,
                    'restaurant_id' => $slot->restaurant_id,
                    'country_id'    => $this->ent_country_id,
                    'status'        => 'ACTIVE',
                    'created_by'    => Auth::id(),
                ]);
                $this->flash('تم منح استحقاق الوجبة للوفد المحدد بنجاح.');
            } else {
                $this->flash('هذا الوفد يملك استحقاقاً لهذه الوجبة مسبقاً.', 'warning');
            }
        } else {
            $this->validate(['ent_user_id' => 'required|exists:users,id']);

            MealEntitlement::firstOrCreate(
                ['meal_slot_id' => $this->ent_meal_slot_id, 'user_id' => $this->ent_user_id],
                [
                    'uuid'          => (string) Str::uuid(),
                    'restaurant_id' => $slot->restaurant_id,
                    'country_id'    => User::find($this->ent_user_id)?->country_id,
                    'status'        => 'ACTIVE',
                    'created_by'    => Auth::id(),
                ]
            );

            $this->flash('تم منح استحقاق الوجبة للمشارك بنجاح.');
        }

        $this->entitlementFormOpen = false;
    }

    public function revokeEntitlement(int $id): void
    {
        MealEntitlement::findOrFail($id)->delete();
        $this->flash('تم إلغاء واستبعاد الاستحقاق.');
    }

    // ────────────────────────────────────────────────────────
    // DELETE CONFIRMATION
    // ────────────────────────────────────────────────────────
    public function confirmDelete(string $type, int $id): void
    {
        $this->deleteTargetType = $type;
        $this->deleteTargetId   = $id;
        $this->deleteOpen       = true;
    }

    public function executeDelete(): void
    {
        if (!$this->deleteTargetId) return;

        if ($this->deleteTargetType === 'restaurant') {
            Restaurant::findOrFail($this->deleteTargetId)->delete();
            $this->flash('تم حذف المطعم بنجاح.');
        } elseif ($this->deleteTargetType === 'slot') {
            MealSlot::findOrFail($this->deleteTargetId)->delete();
            $this->flash('تم حذف خانة الوجبة.');
        } elseif ($this->deleteTargetType === 'entitlement') {
            MealEntitlement::findOrFail($this->deleteTargetId)->delete();
            $this->flash('تم حذف الاستحقاق.');
        }

        $this->deleteOpen       = false;
        $this->deleteTargetId   = null;
        $this->deleteTargetType = '';
    }

    // ────────────────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────────────────
    public function render()
    {
        $flashMessage = $this->flashMessage;
        $flashType    = $this->flashType;
        // Today's KPIs
        $todaySlots      = MealSlot::with('restaurant', 'scans')->whereDate('date', today())->get();
        $totalAuthorized = MealScan::whereDate('scanned_at', today())->where('status', 'AUTHORIZED')->count();
        $totalDenied     = MealScan::whereDate('scanned_at', today())->where('status', 'DENIED')->count();
        $totalDuplicate  = MealScan::whereDate('scanned_at', today())->where('status', 'DUPLICATE')->count();
        $totalCapacity   = $todaySlots->sum('max_capacity');

        // Restaurants list
        $restaurants = Restaurant::withCount(['mealSlots'])
            ->when($this->search, fn($q) => $q->where('name_ar', 'like', "%{$this->search}%")->orWhere('name_fr', 'like', "%{$this->search}%"))
            ->when($this->filterStatus === 'active',   fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
            ->latest()
            ->paginate(12);

        // Meal Slots
        $slotsDate = $this->filterDate ?: today()->toDateString();
        $mealSlots = MealSlot::with(['restaurant', 'scans'])
            ->when($slotsDate, fn($q) => $q->whereDate('date', $slotsDate))
            ->when($this->filterMeal, fn($q) => $q->where('meal_type', $this->filterMeal))
            ->orderBy('start_time')
            ->paginate(15);

        // Entitlements list
        $entitlements = MealEntitlement::with(['mealSlot.restaurant', 'user', 'country'])
            ->when($slotsDate, fn($q) => $q->whereHas('mealSlot', fn($s) => $s->whereDate('date', $slotsDate)))
            ->when($this->filterMeal, fn($q) => $q->whereHas('mealSlot', fn($s) => $s->where('meal_type', $this->filterMeal)))
            ->latest()
            ->paginate(20);

        // Scans log
        $scansLog = MealScan::with(['mealSlot.restaurant', 'user'])
            ->when($this->filterDate, fn($q) => $q->whereDate('scanned_at', $this->filterDate))
            ->when($this->filterMeal, fn($q) => $q->where('meal_type_snapshot', $this->filterMeal))
            ->when($this->filterStatus, fn($q) => $q->where('status', strtoupper($this->filterStatus)))
            ->when($this->search, fn($q) => $q->where('participant_name_snapshot', 'like', "%{$this->search}%")->orWhere('badge_code', 'like', "%{$this->search}%"))
            ->latest('scanned_at')
            ->paginate(25);

        $allRestaurants = Restaurant::where('is_active', true)->orderBy('name_ar')->get();
        $allCountries   = Country::where('is_active', true)->orderBy('name_ar')->get();
        $allUsers       = User::where('is_active', true)->orderBy('name')->take(200)->get();

        $openSlotsToday = MealSlot::with('restaurant')
            ->whereDate('date', today())
            ->orderBy('start_time')
            ->get();

        $selectedSlot = $this->selectedSlotId ? MealSlot::with('restaurant')->find($this->selectedSlotId) : null;

        return view('livewire.admin.restaurants.index', array_merge(
            $this->all(),
            compact(
                'restaurants', 'mealSlots', 'entitlements', 'scansLog',
                'todaySlots', 'totalAuthorized', 'totalDenied', 'totalDuplicate', 'totalCapacity',
                'allRestaurants', 'allCountries', 'allUsers', 'openSlotsToday', 'selectedSlot'
            )
        ));
    }

    // ── Helpers ───────────────────────────────────────────────
    private function flash(string $msg, string $type = 'success'): void
    {
        $this->flashMessage = $msg;
        $this->flashType    = $type;
        $this->dispatch('flash-message');
    }

    private function resetRestaurantForm(): void
    {
        $this->restaurantEditing = false;
        $this->restaurantEditId  = null;
        $this->name_ar = $this->name_fr = $this->name_en = '';
        $this->location = $this->contact_phone = $this->notes_r = '';
        $this->capacity  = 300;
        $this->is_active = true;
    }

    private function resetSlotForm(): void
    {
        $this->slotEditing        = false;
        $this->slotEditId         = null;
        $this->slot_restaurant_id = null;
        $this->slot_date          = today()->toDateString();
        $this->slot_meal_type     = 'LUNCH';
        $this->slot_start         = '12:00';
        $this->slot_end           = '14:30';
        $this->slot_capacity      = 300;
        $this->slot_is_open       = true;
        $this->slot_notes         = '';
    }

    // Export Scans to CSV
    public function exportScansCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $date = $this->filterDate ?: today()->toDateString();

        return response()->streamDownload(function () use ($date) {
            $bom = "\xEF\xBB\xBF";
            echo $bom;
            echo "التاريخ,الوجبة,المطعم,الاسم,الدولة,رمز الشارة,الحالة,سبب الرفض,وقت المسح\n";

            MealScan::with(['mealSlot.restaurant', 'user'])
                ->whereDate('scanned_at', $date)
                ->orderBy('scanned_at')
                ->chunk(500, function ($rows) {
                    foreach ($rows as $r) {
                        echo implode(',', [
                            $r->mealSlot?->date?->format('Y-m-d') ?? '',
                            $r->meal_type_snapshot ?? '',
                            '"' . ($r->restaurant_snapshot ?? '') . '"',
                            '"' . ($r->participant_name_snapshot ?? '') . '"',
                            '"' . ($r->country_snapshot ?? '') . '"',
                            $r->badge_code ?? '',
                            $r->status,
                            '"' . ($r->denial_reason ?? '') . '"',
                            $r->scanned_at?->format('H:i:s') ?? '',
                        ]) . "\n";
                    }
                });
        }, "meal_scans_{$date}.csv", ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
