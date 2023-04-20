<?php

/*****************************************************************
 * This file is generated on composer update command by
 * a custom script. 
 * 
 * Do not edit it manually!
 ****************************************************************/

namespace PublishPress\PimplePimple;

use function add_action;
use function do_action;

if (! function_exists('add_action')) {
    return;
}

if (! function_exists(__NAMESPACE__ . '\register3Dot5Dot0Dot5')) {
    if (! class_exists('PublishPress\PimplePimple\Versions')) {
        require_once __DIR__ . '/Versions.php';

        add_action('plugins_loaded', [Versions::class, 'initializeLatestVersion'], 1, 0);
    }

    add_action('plugins_loaded', __NAMESPACE__ . '\register3Dot5Dot0Dot5', 1, 0);

    function register3Dot5Dot0Dot5()
    {
        if (! class_exists('PublishPress\Pimple\Container')) {
            $versions = Versions::getInstance();
            $versions->register('3.5.0.5', __NAMESPACE__ . '\initialize3Dot5Dot0Dot5');
        }
    }

    function initialize3Dot5Dot0Dot5()
    {
        require_once __DIR__ . '/autoload.php';
        do_action('publishpress_pimple_pimple_3Dot5Dot0Dot5_initialized');
    }
}
