<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2839c086510ff6ea6b0942764b159afe
{
    public static $files = array (
        '5c6173e7ff53b1345a459c86908bbeb6' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'ZanySoft\\Zip\\' => 13,
        ),
        'W' => 
        array (
            'Webdevhayes\\LaravelThemeSystem\\Tests\\' => 37,
            'Webdevhayes\\LaravelThemeSystem\\Database\\Factories\\' => 50,
            'Webdevhayes\\LaravelThemeSystem\\' => 31,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Container\\' => 14,
        ),
        'I' => 
        array (
            'Illuminate\\Contracts\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ZanySoft\\Zip\\' => 
        array (
            0 => __DIR__ . '/..' . '/zanysoft/laravel-zip/src',
        ),
        'Webdevhayes\\LaravelThemeSystem\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Webdevhayes\\LaravelThemeSystem\\Database\\Factories\\' => 
        array (
            0 => __DIR__ . '/../..' . '/database/factories',
        ),
        'Webdevhayes\\LaravelThemeSystem\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2839c086510ff6ea6b0942764b159afe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2839c086510ff6ea6b0942764b159afe::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2839c086510ff6ea6b0942764b159afe::$classMap;

        }, null, ClassLoader::class);
    }
}
