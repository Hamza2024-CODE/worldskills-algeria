<?php

namespace App\Services\Certificate;

use App\Models\Certificate;
use App\Models\Registration;
use Illuminate\Support\Carbon;

class CertificateRenderer
{
    protected CertificateTemplateService $templateService;

    public function __construct(?CertificateTemplateService $templateService = null)
    {
        $this->templateService = $templateService ?? new CertificateTemplateService();
    }

    /**
     * Render complete data payload for certificate Blade view.
     */
    public function renderData(?Registration $registration, ?Certificate $certificate = null, string $certType = 'PARTICIPATION', string $token = ''): array
    {
        $template = $this->templateService->getTemplateConfig($certType);

        // Recipient Names (Arabic & English/Latin)
        $nameAr = $registration?->participant?->first_name_ar
            ? ($registration->participant->first_name_ar . ' ' . $registration->participant->last_name_ar)
            : ($certificate?->user?->name ?? 'المترشح / المشارك المعتمد');

        $nameLatin = $registration?->participant?->first_name_fr
            ? ($registration->participant->first_name_fr . ' ' . $registration->participant->last_name_fr)
            : ($certificate?->metadata['recipient_name_latin'] ?? 'Accredited Member');

        // Serial Number
        $serial = $registration?->registration_number
            ?? $certificate?->metadata['serial_number']
            ?? ('WSAP-' . date('Y') . '-' . strtoupper(substr($certType, 0, 4)) . '-' . str_pad((string) rand(1, 99999), 6, '0', STR_PAD_LEFT));

        // Date
        $rawDate = $certificate?->issued_at ?? $registration?->created_at ?? now();
        $dateFormatted = Carbon::parse($rawDate)->format('d/m/Y');

        // Secure Verification Token & QR Code
        $effectiveToken = $token ?: ($registration?->verification_token ?? $certificate?->certificate_uuid ?? 'VERIFIED-WSAP-2026');
        $verifyUrl = route('verify', ['token' => $effectiveToken]);
        $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 150);

        return [
            'template'             => $template,
            'background_url'       => '/' . ltrim($template['background'], '/'),
            'recipient_name_ar'    => $nameAr,
            'recipient_name_latin' => $nameLatin,
            'date_formatted'       => $dateFormatted,
            'serial_number'        => $serial,
            'token'                => $effectiveToken,
            'verify_url'           => $verifyUrl,
            'qr_code_url'          => $qrCodeUrl,
            'fields'               => $template['fields'],
        ];
    }
}
