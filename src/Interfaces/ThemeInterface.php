<?php

namespace Webdevhayes\LaravelThemeSystem\Interfaces;

use Illuminate\Support\Collection;

interface ThemeInterface
{
    public function activateTheme(string $themeName) : bool;

    public function getThemes() : Collection;

    public function themeInfoFields() : Collection;

    public function getThemesFolderPath() : string;

    public function setThemesFolderPath(string $path    );

    public function uploadThemeZip();
}