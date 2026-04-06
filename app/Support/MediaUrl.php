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

        $normalized = ltrim(str_replace('\\', '/', $normalized), '/');

        if (str_contains($normalized, '/')) {
            return self::absolute('img/Tour/' . $normalized);
        }

        $folder = self::detectTourFolder($normalized);

        $rootRelativePath = 'img/Tour/' . $normalized;
        if (self::publicAssetExists($rootRelativePath)) {
            return self::absolute($rootRelativePath);
        }

        $relativePath = $folder !== null
            ? 'img/Tour/' . $folder . '/' . $normalized
            : $rootRelativePath;

        return self::absolute($relativePath);
    }

    private static function publicAssetExists(string $relativePath): bool
    {
        $fullPath = public_path(str_replace('/', DIRECTORY_SEPARATOR, ltrim($relativePath, '/')));

        return is_file($fullPath);
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