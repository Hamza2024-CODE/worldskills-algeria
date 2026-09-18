<?php

namespace App\Livewire\Public;

use App\Models\Certificate;
use App\Models\Registration;
use App\Services\CertificateService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class OfficialCertificate extends Component
{
    public ?Registration $registration = null;
    public ?Certificate $certificate = null;
    public string $certType = 'PARTICIPATION';
    public string $token = '';

    public function mount(string $identifier, ?string $type = null)
    {
        $service = new CertificateService();

        // 1. Try finding registration by number or token
        $this->registration = $service->verifyByNumber($identifier) 
            ?? $service->verifyByToken($identifier);

        if ($this->registration) {
            $regStatus = is_object($this->registration->status) ? ($this->registration->status->value ?? 'APPROVED') : ($this->registration->status ?? 'APPROVED');
            if (strtoupper((string)$regStatus) === 'REJECTED') {
                abort(403, 'الشهادة الرسمية غير متاحة للملفات المرفوضة. يحق للمشاركين والمقبولين رسمياً فقط استخراج شهادة المشاركة.');
            }
            $this->token = $this->registration->verification_token;
            
            if ($type) {
                $this->certType = strtoupper($type);
            } else {
                $userRole = $this->registration->user?->roles->first()?->name;
                $this->certType = match ($userRole) {
                    'MEDIA_MANAGER'      => 'MEDIA',
                    'EXECUTIVE_VIEWER'   => 'DELEGATION_HEAD',
                    'JUDGE', 'EXPERT'    => 'EXPERT_JUDGE',
                    'ORGANIZATION_ADMIN' => 'ORGANIZER',
                    default              => 'PARTICIPATION',
                };
            }
        } else {
            // 2. Try finding Certificate model directly
            $this->certificate = Certificate::with(['user', 'skill', 'registration'])
                ->where('certificate_uuid', $identifier)
                ->orWhere('verification_token_hash', hash('sha256', $identifier))
                ->first();

            if (!$this->certificate) {
                abort(404, 'الشهادة الرسمية المطلوب الاستعلام عنها غير موجودة.');
            }

            $this->certType = $this->certificate->certificate_type;
            $this->registration = $this->certificate->registration;
            $this->token = $identifier;
        }
    }

    public function render()
    {
        $renderer = new \App\Services\Certificate\CertificateRenderer();
        $data = $renderer->renderData($this->registration, $this->certificate, $this->certType, $this->token);

        return view('livewire.public.official-certificate', $data);
    }
}
