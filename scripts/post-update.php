<?php

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

// Update autoload-classmap.php removing lines starting with "PublishPress\Psr\Container".
function updateAutoloadClassmap()
{
    $file = __DIR__ . '/../lib/autoload-classmap.php';
    $contents = file_get_contents($file);
    $contents = preg_replace('/[\s]*[\'"]PublishPress\\\Psr\\\Container\\\.*,/', '', $contents);
    file_put_contents($file, $contents);
}

deleteDirectory(__DIR__ . '/../lib/psr');
updateAutoloadClassmap();
