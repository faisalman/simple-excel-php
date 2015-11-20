<?php

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    public static function init()
    {
        error_reporting(E_ALL | E_STRICT);

        static::initAutoloader();
    }

    protected static function initAutoloader()
    {
        $vendorPath = realpath(__DIR__ . '/../vendor');

        if (!is_readable($vendorPath . '/autoload.php')) {
            throw new \RuntimeException(
                'Unable to locate autoloader. Run `composer install` from the project root directory.'
            );
        }

        include $vendorPath . '/autoload.php';
    }
}

Bootstrap::init();
