<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0bd5588aa449f733e82b620e21e8cc45
{
    public static $files = array (
        'ad155f8f1cf0d418fe49e248db8c661b' => __DIR__ . '/..' . '/react/promise/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'o' => 
        array (
            'olbie\\MiniQ\\' => 12,
        ),
        'R' => 
        array (
            'React\\Stream\\' => 13,
            'React\\Socket\\' => 13,
            'React\\Promise\\' => 14,
            'React\\EventLoop\\' => 16,
            'React\\Dns\\' => 10,
            'React\\Cache\\' => 12,
        ),
        'E' => 
        array (
            'Evenement\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'olbie\\MiniQ\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'React\\Stream\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/stream/src',
        ),
        'React\\Socket\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/socket/src',
        ),
        'React\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/promise/src',
        ),
        'React\\EventLoop\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/event-loop/src',
        ),
        'React\\Dns\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/dns/src',
        ),
        'React\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/cache/src',
        ),
        'Evenement\\' => 
        array (
            0 => __DIR__ . '/..' . '/evenement/evenement/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0bd5588aa449f733e82b620e21e8cc45::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0bd5588aa449f733e82b620e21e8cc45::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0bd5588aa449f733e82b620e21e8cc45::$classMap;

        }, null, ClassLoader::class);
    }
}