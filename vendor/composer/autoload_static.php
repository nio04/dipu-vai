<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteba462ec9018f27dd782afee828e1834
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\Views\\' => 10,
            'App\\Traits\\' => 11,
            'App\\Models\\' => 11,
            'App\\Controllers\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\Views\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/views',
        ),
        'App\\Traits\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteba462ec9018f27dd782afee828e1834::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteba462ec9018f27dd782afee828e1834::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteba462ec9018f27dd782afee828e1834::$classMap;

        }, null, ClassLoader::class);
    }
}
