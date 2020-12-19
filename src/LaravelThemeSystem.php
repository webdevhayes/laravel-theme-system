<?php

namespace Webdevhayes\LaravelThemeSystem;

use Illuminate\Support\Collection;
use Webdevhayes\LaravelThemeSystem\Models\LaravelThemeSystem as ThemeSystemModel;

class LaravelThemeSystem
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


    public function __construct()
    {
       $this->path = $this->getThemesFolderPath();
       $this->directoryHandler = $this->directoryHandle($this->path);
    }

    public function activateTheme(string $themeName) : bool
    {
        $newTarget = null;
        $link = base_path('public/themes');

        $isViewsPublished = $this->isAssetsPublished();
        if ( !is_link($link) ) {
            if($isViewsPublished) {
                ThemeSystemModel::updateOrCreate(
                    ['id' => 1],
                    ['name' => $themeName]
                );
                $newTarget = resource_path("views/vendor/laravel-theme-system/themes/default/assets");
                symlink($newTarget, $link);
            } else {
                ThemeSystemModel::updateOrCreate(
                    ['id' => 1],
                    ['name' => $themeName]
                );
                $newTarget = __DIR__.'/../resources/views/themes/default/assets';
                symlink($newTarget, $link);
            }
        } else {
            unlink(base_path('public/themes'));
            ThemeSystemModel::updateOrCreate(
                ['id' => 1],
                ['name' => $themeName]
            );
            $newTarget = resource_path("views/vendor/laravel-theme-system/themes/".$themeName."/assets");
            symlink($newTarget, $link);
        }

        return true;
    }

    public function getThemes() : Collection
    {
        $this->themes = collect();
        $isViewsPublished = $this->isAssetsPublished();

        foreach( $this->getThemeDirectoryNames() as $dir )
        {
            $this->themes[$dir] = collect();
            if($isViewsPublished) {
                $filePath = base_path("/resources/views/vendor/laravel-theme-system/themes/{$dir}/theme.php");
            } else {
                $filePath = __DIR__."/../resources/views/themes/" . $dir . "/theme.php";
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
        dd($this->themes);
        return $this->themes;
    }

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

    public function getThemesFolderPath(string $path = __DIR__.'/../resources/views/themes') : string
    {
        return $path;
    }

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

    protected function directoryHandle(string $path) : ?\Directory
    {
        return dir($path);
    }

    protected function isAssetsPublished() : bool
    {
        return is_dir(resource_path("views/vendor/laravel-theme-system/themes/default/assets"));
    }

}
