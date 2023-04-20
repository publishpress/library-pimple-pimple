<?php

namespace PublishPress\PimplePimple;

if (! function_exists(__NAMESPACE__ . '\\register2Dot0Dot0Dot1')) {
    if (! class_exists('PublishPress\\PimplePimple\\Versions')) {
        require_once __DIR__ . '/Versions.php';

        add_action('plugins_loaded', [Versions::class, 'initializeLatestVersion'], 1, 0);
    }

    add_action('plugins_loaded', __NAMESPACE__ . '\\register2Dot0Dot0Dot1', 1, 0);

    function register2Dot0Dot0Dot1()
    {
        if (! class_exists('PublishPress\\Psr\\Container\\ContainerInterface')) {
            $versions = Versions::getInstance();
            $versions->register('2.0.0.1', __NAMESPACE__ . '\\initialize2Dot0Dot0Dot1');
        }
    }

    function initialize2Dot0Dot0Dot1()
    {
        require_once __DIR__ . '/autoload.php';
    }
}
