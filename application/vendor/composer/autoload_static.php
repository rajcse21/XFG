<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7123d87cdb9fc984e948537d3dd9c6ae
{
    public static $files = array (
        'ce89ac35a6c330c55f4710717db9ff78' => __DIR__ . '/..' . '/kriswallsmith/assetic/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
    );

    public static $prefixesPsr0 = array (
        'A' => 
        array (
            'Assetic' => 
            array (
                0 => __DIR__ . '/..' . '/kriswallsmith/assetic/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7123d87cdb9fc984e948537d3dd9c6ae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7123d87cdb9fc984e948537d3dd9c6ae::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7123d87cdb9fc984e948537d3dd9c6ae::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
