<?php

namespace App\Support;

class MediaUrl
{
    public static function absolute(?string $path): ?string
    {
        $normalized = trim((string) $path);

        if ($normalized === '') {
            return null;
        }

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        $origin = request()?->getSchemeAndHttpHost() ?: rtrim((string) config('app.url'), '/');

        return $origin . '/' . ltrim(str_replace('\\', '/', $normalized), '/');
    }

    public static function roomImage(?string $filename): ?string
    {
        $normalized = trim((string) $filename);

        if ($normalized === '') {
            return null;
        }

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        $folder = self::detectRoomFolder($normalized);
        $relativePath = $folder !== null
            ? 'img/Phong/' . $folder . '/' . ltrim($normalized, '/')
            : 'img/Phong/' . ltrim($normalized, '/');

        return self::absolute($relativePath);
    }

    public static function tourImage(?string $filename): ?string
    {
        $normalized = trim((string) $filename);

        if ($normalized === '') {
            return null;
        }

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        $folder = self::detectTourFolder($normalized);

        if ($folder === null && !str_contains($normalized, '/')) {
            return null;
        }

        $relativePath = $folder !== null
            ? 'img/Tour/' . $folder . '/' . ltrim($normalized, '/')
            : 'img/Tour/' . ltrim($normalized, '/');

        return self::absolute($relativePath);
    }

    private static function detectRoomFolder(string $filename): ?string
    {
        $normalized = strtolower($filename);
        $map = [
            'donview' => 'DonView',
            'don' => 'Don',
            'doiview' => 'DoiView',
            'doi' => 'Doi',
            'gdview' => 'GDView',
            'gd' => 'GD',
        ];

        foreach ($map as $prefix => $folder) {
            if (str_starts_with($normalized, $prefix)) {
                return $folder;
            }
        }

        return null;
    }

    private static function detectTourFolder(string $filename): ?string
    {
        $normalized = strtolower($filename);

        if (str_starts_with($normalized, 'tournuicam')) {
            return 'TourNuiCam';
        }

        if (str_starts_with($normalized, 'tour30_4')) {
            return 'Tour30_4';
        }

        return null;
    }

}