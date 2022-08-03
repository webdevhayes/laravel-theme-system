<?php

namespace Webdevhayes\LaravelThemeSystem;

use Illuminate\Support\Collection;
use Webdevhayes\LaravelThemeSystem\Repositories\ThemeRepository;

class LaravelThemeSystem
{
    private ThemeRepository $themeRepository;

    public function __construct()
    {
        $this->themeRepository = new ThemeRepository();
    }


    /**
     * Activate Theme
     * @param string $themeName
     * @return void
     */
    public function activateTheme(string $themeName) : bool
    {
        return $this->themeRepository->activateTheme($themeName);
    }

    /**
     * @return Collection
     */
    public function getThemes(): Collection
    {
        return $this->themeRepository->getThemes();
    }

}
