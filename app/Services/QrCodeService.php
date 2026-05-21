<?php

namespace App\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class QrCodeService
{
    /**
     * Generates a signed URL and a physical QR Code SVG image.
     * Returns an array with the generated url and the image path.
     * 
     * @return array{url: string, path: string}
     */
    public function generateForTicket(): array
    {
        // 1. Generate unique unguessable token
        $token = (string) Str::uuid();

        // 2. Generate signed URL for scanning
        // Dit roept de route 'tickets.scan' aan, die we straks definiëren.
        $signedUrl = URL::signedRoute('tickets.scan', ['token' => $token]);

        // 3. Generate QR Code SVG
        $renderer = new ImageRenderer(
            new RendererStyle(300, 1),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $svgString = $writer->writeString($signedUrl);

        // 4. Save to storage
        $filename = 'qr_codes/' . $token . '.svg';
        Storage::disk('public')->put($filename, $svgString);

        return [
            'url' => $signedUrl,
            'path' => $filename
        ];
    }
}
