<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb39af4b1a1898a728fc64c4f56dbb1d5
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VariableAnalysis\\' => 17,
        ),
        'S' => 
        array (
            'SlevomatCodingStandard\\' => 23,
        ),
        'P' => 
        array (
            'PHPStan\\PhpDocParser\\' => 21,
        ),
        'D' => 
        array (
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VariableAnalysis\\' => 
        array (
            0 => __DIR__ . '/..' . '/sirbrillig/phpcs-variable-analysis/VariableAnalysis',
        ),
        'SlevomatCodingStandard\\' => 
        array (
            0 => __DIR__ . '/..' . '/slevomat/coding-standard/SlevomatCodingStandard',
        ),
        'PHPStan\\PhpDocParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpstan/phpdoc-parser/src',
        ),
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb39af4b1a1898a728fc64c4f56dbb1d5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb39af4b1a1898a728fc64c4f56dbb1d5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}