<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Single source of truth for turning a raw `image` column value (whatever
 * shape it happens to be in) into a working, cache-busted, public URL.
 *
 * A product's stored image path can come from three different eras of this
 * project without a symlink being involved:
 *
 *   1. Seed / demo images shipped in the repo   -> "pic/scarf.webp"
 *      (lives directly under public/pic/...)
 *
 *   2. New admin uploads (current system)       -> "uploads/products/xxx.jpg"
 *      (lives directly under public/uploads/products/..., served by the
 *      webserver with no symlink needed)
 *
 *   3. Legacy admin uploads (old Filament disk) -> "products/xxx.jpg"
 *      (lives under storage/app/public/products/..., which used to be
 *      exposed only via the public/storage symlink). These are now served
 *      through the `legacy-product-image` route instead, so they keep
 *      working even when the symlink was never created.
 *
 * Product::image_url, ProductImage::image_url and the Filament products
 * table all delegate here so the three stay in sync and there is only one
 * place that encodes this logic (see requirement to avoid duplicate/
 * conflicting image-handling code across the app).
 */
class ProductImageResolver
{
    public const PLACEHOLDER = 'pic/p1.webp';

    /**
     * Resolve a stored image path into a public, cache-busted URL.
     */
    public static function url(?string $path): string
    {
        if (blank($path)) {
            return asset(self::PLACEHOLDER);
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $normalized = self::normalize($path);

        // 1 & 2: anything that already lives directly under public/
        // (seed images in public/pic/, new uploads in public/uploads/products/,
        // or any other path someone placed straight into public/).
        $absolute = public_path($normalized);

        if (is_file($absolute)) {
            return asset($normalized) . self::versionSuffix(@filemtime($absolute));
        }

        // 3: legacy uploads that only exist under storage/app/public/,
        // served without relying on the storage:link symlink.
        if (Storage::disk('public')->exists($normalized)) {
            return route('legacy-product-image', ['path' => $normalized])
                . self::versionSuffix(Storage::disk('public')->lastModified($normalized) ?: null);
        }

        return asset(self::PLACEHOLDER);
    }

    /**
     * Unix timestamp the underlying file was last modified. Used to detect
     * whether a product's image actually changed (for the storefront's
     * no-refresh polling), independent of any query-string already baked
     * into url().
     */
    public static function version(?string $path): ?int
    {
        if (blank($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return null;
        }

        $normalized = self::normalize($path);
        $absolute = public_path($normalized);

        if (is_file($absolute)) {
            return @filemtime($absolute) ?: null;
        }

        if (Storage::disk('public')->exists($normalized)) {
            return Storage::disk('public')->lastModified($normalized) ?: null;
        }

        return null;
    }

    /**
     * Strip a leading slash and an accidental "storage/" prefix (older code
     * in this project sometimes stored that prefix directly in the DB).
     */
    private static function normalize(string $path): string
    {
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return $path;
    }

    private static function versionSuffix(?int $timestamp): string
    {
        return $timestamp ? ('?v=' . $timestamp) : '';
    }
}
