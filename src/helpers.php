<?php

use Webdevhayes\LaravelThemeSystem\Models\LaravelThemeSystem;

if (! function_exists('themeViewPath')) {
    /**
     * Get the evaluated view path for active theme.
     *
     * @param string $path
     * @return string
     */
    function themeViewPath(string $path)
    {
        if ( themeSystemAssetsPublished() ) {
            return 'vendor.laravel-theme-system.themes.' . LaravelThemeSystem::first()->name . '.' . $path;
        } else {
            return 'laravel-theme-system::themes.' . LaravelThemeSystem::first()->name . '.' . $path;
        }

    }
}

if (! function_exists('themeName')) {
    /**
     * Get the evaluated view path for active theme.
     *
     * @return string
     */
    function themeName()
    {
        return LaravelThemeSystem::where('active', 1)->first()->name;
    }
}

if (! function_exists('themeSystemAssetsPublished')) {
    /**
     * is package assets published
     *
     * @return bool
     */
    function themeSystemAssetsPublished()
    {
        return is_dir(resource_path("views/vendor/laravel-theme-system/themes/default/assets"));
    }
}

if (! function_exists('assetCache')) {
    /**
     * get asset and cache
     *
     * @return bool
     */
    function assetCache(string $filePath)
    {
        return asset($filePath).'?'.filemtime(base_path("public/{$filePath}"));
    }
}