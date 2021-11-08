<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaaa05f1591949011a63cbfa967dfff9f
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WordpressCustomSettings\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WordpressCustomSettings\\' => 
        array (
            0 => __DIR__ . '/..' . '/vaskou/wordpress-custom-settings/WordpressCustomSettings',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaaa05f1591949011a63cbfa967dfff9f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaaa05f1591949011a63cbfa967dfff9f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaaa05f1591949011a63cbfa967dfff9f::$classMap;

        }, null, ClassLoader::class);
    }
}
