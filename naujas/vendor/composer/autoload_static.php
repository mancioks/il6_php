<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd1b616873ad211fdf086d368478d26ab
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/app/code',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInitd1b616873ad211fdf086d368478d26ab::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInitd1b616873ad211fdf086d368478d26ab::$classMap;

        }, null, ClassLoader::class);
    }
}