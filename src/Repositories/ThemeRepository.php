<?php

namespace Webdevhayes\LaravelThemeSystem\Repositories;

use Webdevhayes\LaravelThemeSystem\Interfaces\ThemeInterface;
use Webdevhayes\LaravelThemeSystem\Models\LaravelThemeSystem as ThemeSystemModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ThemeRepository implements ThemeInterface
{
    /**
     * @var Collection
     */
    protected Collection $themesList;

    /**
     * @var \Directory|false|null
     */
    protected ?\Directory $directoryHandler;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var Collection|null
     */
    protected ?Collection $themeDirectories = null;

    /**
     * @var Collection|null
     */
    protected ?Collection $themes = null;
    private bool $assetsPublished;

    public function __construct()
    {
        $this->setThemesFolderPath(resource_path('views/vendor/laravel-theme-system/themes'));

        $this->assetsPublished = $this->isAssetsPublished();

        if (!$this->assetsPublished) {
            $this->setThemesFolderPath(__DIR__.'/../../resources/views/themes');
        }

        $this->directoryHandler = $this->directoryHandle($this->path);
    }

    /**
     * Activate Theme
     * @param string $themeName
     * @return bool
     */
    public function activateTheme(string $themeName) : bool
    {
        $newTarget = null;
        $link = base_path('public/theme');

        $isViewsPublished = $this->isAssetsPublished();
        if ( !is_link($link) )
        {
            if($isViewsPublished)
            {
                if (!$this->isThemePresent($themeName)) {
                    return false;
                }

                $updated = DB::transaction(function () use ($themeName) {
                    ThemeSystemModel::where('active', 1)->first()->update([
                        'active' => 0
                    ]);
                    ThemeSystemModel::updateOrCreate(
                        ['name' => $themeName],
                        ['active' => 1]
                    );
                    return true;
                });

                if ($updated) {
                    $newTarget = $this->path."/{$themeName}/assets/dist";
                    symlink($newTarget, $link);
                }
            } else
            {
                $updated = DB::transaction(function () use ($themeName) {
                    ThemeSystemModel::where('active', 1)->first()->update([
                        'active' => 0
                    ]);
                    ThemeSystemModel::updateOrCreate(
                        ['name' => $themeName],
                        ['active' => 1]
                    );
                });

                if ($updated) {
                    $newTarget = $this->path.'/default/assets/dist';
                    symlink($newTarget, $link);
                }
            }
        } else
        {
            if (!$this->isThemePresent($themeName)) {
                return false;
            }

            $updated = DB::transaction(function () use ($themeName) {
                ThemeSystemModel::where('active', 1)->first()->update([
                    'active' => 0
                ]);

                ThemeSystemModel::updateOrCreate(
                    ['name' => $themeName],
                    ['active' => 1]
                );
            });

            if ($updated) {
                unlink(base_path('public/theme'));
                $newTarget = $this->path . "/" . $themeName . "/assets/dist";
                symlink($newTarget, $link);
            }
        }

        return true;
    }

    /**
     * Get all themes.
     * @return Collection
     */
    public function getThemes() : Collection
    {
        $this->themes = collect();
        $isViewsPublished = $this->isAssetsPublished();

        foreach( $this->getThemeDirectoryNames() as $dir )
        {
            $this->themes[$dir] = collect();
            if($isViewsPublished) {
                $filePath = $this->getThemesFolderPath()."/{$dir}/theme.php";
            } else {
                $filePath = __DIR__."/" . $dir . "/theme.php";
            }
            if ( file_exists($filePath) ) {
                $data = file_get_contents($filePath);
                foreach(preg_split("/((\r?\n)|(\r\n?))/", $data) as $line)
                {
                    if (!empty($line)) {
                        $themeInfoLineArray = explode(':', $line, 2);
                        if( !empty($themeInfoLineArray[1])) {
                            $this->themes->get($dir)->put($themeInfoLineArray[0], rtrim(ltrim($themeInfoLineArray[1])));
                        }
                    }
                }
            } else {
                $this->themes->get($dir)->put('error', 'theme.php is missing from the theme folder');
            }
        }

        return $this->themes;
    }

    /**
     * Get all theme fields.
     * @return Collection
     */
    public function themeInfoFields() : Collection
    {
        return collect(
            [
                'Theme Name',
                'Version',
                'Theme URI',
                'Author',
                'Author URI'
            ]
        );
    }

    /**
     * Get themes folder path.
     * @param string $path
     * @return string
     */
    public function getThemesFolderPath() : string
    {
        return $this->path;
    }

    /**
     * Sets Theme folder path.
     * @param string $path
     * @return void
     */
    public function setThemesFolderPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return void
     */
    public function uploadThemeZip()
    {

    }

    /**
     * @return Collection
     */
    protected function getThemeDirectoryNames() : Collection
    {
        $dir = $this->directoryHandler;
        $this->themeDirectories = collect();

        while (false !== ($entry = $dir->read())) {
            if ($entry != '.' && $entry != '..') {
                if (is_dir($this->path . '/' .$entry)) {
                    $this->themeDirectories->push($entry);
                }
            }
        }

        return $this->themeDirectories;
    }

    /**
     * Handles Directory for theme
     * @param string $path
     * @return \Directory|null
     */
    protected function directoryHandle(string $path) : ?\Directory
    {
        return dir($path);
    }

    /**
     * Is theme assets published?
     * @return bool
     */
    protected function isAssetsPublished() : bool
    {
        return is_dir($this->path."/default/assets");
    }

    /**
     * Check theme trying to be activated exists
     * @param string $themeName
     * @return bool
     */
    private function isThemePresent(string $themeName): bool
    {
        return is_dir($this->path."/{$themeName}");
    }
}