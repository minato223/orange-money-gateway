<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2ca80d2876ed4ec303ff25adbcf01e47
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lamine\\OrangeMoneyGateway\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lamine\\OrangeMoneyGateway\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2ca80d2876ed4ec303ff25adbcf01e47::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2ca80d2876ed4ec303ff25adbcf01e47::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2ca80d2876ed4ec303ff25adbcf01e47::$classMap;

        }, null, ClassLoader::class);
    }
}
