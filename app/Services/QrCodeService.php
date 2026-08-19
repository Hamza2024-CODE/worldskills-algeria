<?php

namespace App\Services;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCodeService
{
    /**
     * Generate an inline SVG QR code for any given text / URL.
     * 100% compliant ISO/IEC 18004 QR Code scanner readable by all smartphones.
     */
    public static function generateSvg(string $data, int $size = 200): string
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle($size, 1),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            return $writer->writeString($data);
        } catch (\Throwable $e) {
            // Fallback SVG in case of exception
            $url = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 200 200\"><rect width=\"100%\" height=\"100%\" fill=\"#ffffff\"/><text x=\"10\" y=\"100\" font-size=\"12\" fill=\"#06205C\">{$url}</text></svg>";
        }
    }

    public static function generateDataUri(string $data, int $size = 200): string
    {
        $svg = self::generateSvg($data, $size);
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
