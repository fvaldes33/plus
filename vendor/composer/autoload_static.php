<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitee2045cf84d0fa27fe98f07985d23685
{
    public static $prefixLengthsPsr4 = array (
        'f' => 
        array (
            'fvaldes\\plus\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'fvaldes\\plus\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitee2045cf84d0fa27fe98f07985d23685::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitee2045cf84d0fa27fe98f07985d23685::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
