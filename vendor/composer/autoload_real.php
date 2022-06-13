<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitea05f91695a3b27f0bccdeac7d11e220
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitea05f91695a3b27f0bccdeac7d11e220', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitea05f91695a3b27f0bccdeac7d11e220', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitea05f91695a3b27f0bccdeac7d11e220::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}