<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\DelegationArrival;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class ArrivalsCenter extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $statusFilter = 'ALL';
    public string $airportFilter = 'ALL';

    // Form Modal State (Create & Edit)
    public bool $showFormModal = false;
    public ?int $editingId = null;

    public ?int $country_id = null;
    public string $arrival_date = '';
    public string $arrival_time = '12:00';
    public string $airline_name = '';
    public string $flight_number = '';
    public string $arrival_airport = 'مطار هواري بومدين الدولي (الجزائر العاصمة)';
    public int $passenger_count = 1;
    public string $status = 'PENDING';
    public string $shuttle_assigned = 'حافلة بروتوكولية معتمدة (VIP Bus)';
    public string $notes = '';
    public $ticket_file = null;

    // Ticket Preview Modal State
    public bool $previewModalOpen = false;
    public ?DelegationArrival $selectedArrival = null;

    // Approve & Assign Shuttle Modal State
    public bool $approveModalOpen = false;
    public ?int $approvingId = null;
    public string $selectedShuttle = 'حافلة بروتوكولية فاخرة (VIP Bus)';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }
    public function updatingAirportFilter(): void { $this->resetPage(); }

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->country_id = Country::orderBy('name_ar')->first()?->id;
        $this->arrival_date = now()->format('Y-m-d');
        $this->arrival_time = '14:30';
        $this->airline_name = 'الخطوط الجوية الجزائرية (Air Algérie)';
        $this->flight_number = 'AH-100' . rand(1, 9);
        $this->arrival_airport = 'مطار هواري بومدين الدولي (الجزائر العاصمة)';
        $this->passenger_count = 12;
        $this->status = 'PENDING';
        $this->shuttle_assigned = 'حافلة بروتوكولية معتمدة (VIP Bus)';
        $this->notes = '';
        $this->ticket_file = null;
        $this->showFormModal = true;
    }

    public function editArrival(int $id): void
    {
        $this->resetValidation();
        $arrival = DelegationArrival::find($id);
        if (!$arrival) return;

        $this->editingId = $arrival->id;
        $this->country_id = $arrival->country_id;
        $this->arrival_date = $arrival->arrival_date ? \Carbon\Carbon::parse($arrival->arrival_date)->format('Y-m-d') : '';
        $this->arrival_time = $arrival->arrival_time ?: '12:00';
        $this->airline_name = $arrival->airline_name;
        $this->flight_number = $arrival->flight_number;
        $this->arrival_airport = $arrival->arrival_airport;
        $this->passenger_count = (int) $arrival->passenger_count;
        $this->status = $arrival->status;
        $this->shuttle_assigned = $arrival->shuttle_assigned ?: 'حافلة بروتوكولية معتمدة (VIP Bus)';
        $this->notes = $arrival->notes ?: '';
        $this->ticket_file = null;

        $this->showFormModal = true;
    }

    public function saveArrival(): void
    {
        $this->validate([
            'country_id'      => 'required|integer|exists:countries,id',
            'arrival_date'    => 'required|date',
            'arrival_time'    => 'required|string',
            'airline_name'    => 'required|string|max:255',
            'flight_number'   => 'required|string|max:100',
            'arrival_airport' => 'required|string|max:255',
            'passenger_count' => 'required|integer|min:1',
            'status'           => 'required|string|in:PENDING,APPROVED,CANCELLED',
            'shuttle_assigned'=> 'nullable|string|max:255',
            'notes'           => 'nullable|string',
            'ticket_file'     => 'nullable|file|max:10240|mimes:pdf,png,jpg,jpeg',
        ]);

        $ticketPath = null;
        $ticketFilename = null;

        if ($this->ticket_file) {
            $ticketFilename = $this->ticket_file->getClientOriginalName();
            $ticketPath = $this->ticket_file->store('tickets', 'public');
        }

        $data = [
            'country_id'       => $this->country_id,
            'arrival_date'     => $this->arrival_date,
            'arrival_time'     => $this->arrival_time,
            'airline_name'     => $this->airline_name,
            'flight_number'    => $this->flight_number,
            'arrival_airport'  => $this->arrival_airport,
            'passenger_count'  => $this->passenger_count,
            'status'           => $this->status,
            'shuttle_assigned' => $this->shuttle_assigned,
            'notes'            => $this->notes,
        ];

        if ($ticketPath) {
            $data['ticket_path'] = $ticketPath;
            $data['ticket_filename'] = $ticketFilename;
        }

        if ($this->editingId) {
            DelegationArrival::where('id', $this->editingId)->update($data);
            session()->flash('success', 'تم تحديث بيانات وصول الوفد بنجاح.');
        } else {
            DelegationArrival::create($data);
            session()->flash('success', 'تم تسجيل وصول الوفد وتخصيص بيانات الرحلة بنجاح.');
        }

        $this->showFormModal = false;
        $this->editingId = null;
    }

    public function deleteArrival(int $id): void
    {
        DelegationArrival::where('id', $id)->delete();
        session()->flash('success', 'تم حذف سجل وصول الوفد بنجاح.');
    }

    public function openTicketPreview(int $id): void
    {
        $arrival = DelegationArrival::with('country')->find($id);
        if ($arrival) {
            $this->selectedArrival = $arrival;
            $this->previewModalOpen = true;
        }
    }

    public function closeTicketPreview(): void
    {
        $this->previewModalOpen = false;
        $this->selectedArrival = null;
    }

    public function openApproveModal(int $id): void
    {
        $this->approvingId = $id;
        $arrival = DelegationArrival::find($id);
        $this->selectedShuttle = $arrival?->shuttle_assigned ?: 'حافلة بروتوكولية فاخرة (VIP Bus)';
        $this->approveModalOpen = true;
    }

    public function approveArrivalConfirmed(): void
    {
        if ($this->approvingId) {
            $arrival = DelegationArrival::find($this->approvingId);
            if ($arrival) {
                $arrival->update([
                    'status' => 'APPROVED',
                    'shuttle_assigned' => $this->selectedShuttle,
                ]);

                if ($this->selectedArrival && $this->selectedArrival->id === $this->approvingId) {
                    $this->selectedArrival->refresh();
                }

                session()->flash('success', 'تم اعتماد استقبال الرحلة وتعيين الحافلة بنجاح!');
            }
        }
        $this->approveModalOpen = false;
        $this->approvingId = null;
    }

    public function render()
    {
        $query = DelegationArrival::with('country');

        if (!empty($this->search)) {
            $s = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('airline_name', 'like', $s)
                  ->orWhere('flight_number', 'like', $s)
                  ->orWhere('arrival_airport', 'like', $s)
                  ->orWhereHas('country', function ($cq) use ($s) {
                      $cq->where('name_ar', 'like', $s)
                        ->orWhere('name_en', 'like', $s)
                        ->orWhere('code', 'like', $s);
                  });
            });
        }

        if ($this->statusFilter !== 'ALL') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->airportFilter !== 'ALL') {
            $query->where('arrival_airport', 'like', '%' . $this->airportFilter . '%');
        }

        $arrivals = $query->latest('arrival_date')->paginate(15);

        // Database Metrics
        $totalArrivalsCount = DelegationArrival::count();
        $totalDelegatesCount = (int) DelegationArrival::sum('passenger_count');
        $pendingCount = DelegationArrival::where('status', 'PENDING')->count();
        $approvedCount = DelegationArrival::where('status', 'APPROVED')->count();

        $allCountries = Country::orderBy('name_ar')->get();

        return view('livewire.admin.arrivals-center', [
            'arrivals'            => $arrivals,
            'totalArrivalsCount'  => $totalArrivalsCount,
            'totalDelegatesCount' => $totalDelegatesCount,
            'pendingCount'        => $pendingCount,
            'approvedCount'       => $approvedCount,
            'allCountries'        => $allCountries,
        ]);
    }
}
