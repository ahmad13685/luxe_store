<?php

namespace App\Http\Controllers;

use App\Support\ProductImageResolver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves images that were uploaded through the old Filament "public" disk
 * (storage/app/public/products/...) directly, so they keep working even on
 * a machine where `php artisan storage:link` was never run.
 *
 * New uploads no longer use this path at all (see ProductForm, which now
 * saves straight into public/uploads/products), so this controller exists
 * purely for backward compatibility with images uploaded before that change.
 */
class LegacyProductImageController extends Controller
{
    public function show(string $path): Response
    {
        $path = ltrim($path, '/');

        if (! Storage::disk('public')->exists($path)) {
            // Never leak filesystem details to the client — just fall back
            // to the same placeholder the rest of the storefront uses.
            return redirect(asset(ProductImageResolver::PLACEHOLDER));
        }

        $absolute = Storage::disk('public')->path($path);

        return response()->file($absolute, [
            'Content-Type' => File::mimeType($absolute) ?: 'application/octet-stream',
            'Cache-Control' => 'public, max-age=604800, immutable',
        ]);
    }
}
