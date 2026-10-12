<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ensureRequiredDirectoriesExist();
    }

    /**
     * Safety net for fresh installs / ZIP transfers to a new machine: make
     * sure the directories Laravel and the product-image system need are
     * present, without ever touching existing files. This is intentionally
     * a no-op on every normal request once the directories already exist.
     */
    private function ensureRequiredDirectoriesExist(): void
    {
        $directories = [
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/testing'),
            storage_path('logs'),
            storage_path('app/public'),
            storage_path('app/private'),
            base_path('bootstrap/cache'),
            public_path('uploads/products'),
        ];

        foreach ($directories as $directory) {
            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }
        }
    }
}
