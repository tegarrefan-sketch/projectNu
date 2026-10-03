<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrCodeService
{
    /**
     * Generate Data URI base64 SVG for direct usage in <img src="..." />
     */
    public static function generateDataUri(string $data): string
    {
        return (new QRCode())->render($data);
    }

    /**
     * Generate raw SVG string
     */
    public static function generateSvg(string $data): string
    {
        $options = new QROptions();
        $options->imageBase64 = false;

        return (new QRCode($options))->render($data);
    }
}
