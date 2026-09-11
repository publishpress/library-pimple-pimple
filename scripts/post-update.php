<?php

/**
 * Strauss prefixes both pimple/pimple and psr/container so Pimple's Psr11
 * wrappers use PublishPress\Psr\Container. Types must come from
 * publishpress/psr-container, not a second copy under lib/psr.
 *
 * Strauss 0.29 runtime autoload is lib/composer/, not lib/autoload-classmap.php.
 * Strip PublishPress\Psr\Container from both legacy and Composer maps.
 */

function deleteDirectory($dir)
{
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

/**
 * True when a line maps the nested PublishPress\Psr\Container package.
 * Composer writes namespace separators as doubled backslashes in PHP source.
 */
function lineMapsNestedPsrContainer($line)
{
    // file_get_contents sees Composer’s escaped separators as \\ in the source.
    return strpos($line, 'PublishPress\\\\Psr\\\\Container') !== false;
}

function stripPsrContainerFromPhpMap($file)
{
    if (!file_exists($file)) {
        return;
    }

    $contents = file_get_contents($file);
    if ($contents === false) {
        return;
    }

    $lines = preg_split("/\r\n|\n|\r/", $contents);
    $out = [];
    $skipBlock = 0;

    foreach ($lines as $line) {
        if ($skipBlock > 0) {
            $skipBlock--;
            continue;
        }

        if (lineMapsNestedPsrContainer($line)) {
            // Drop multiline PSR-4 prefixDirs entries:
            // 'PublishPress\Psr\Container\' =>
            // array (
            //     0 => ...,
            // ),
            if (preg_match('/=>\s*$/', $line)) {
                $skipBlock = 3;
            }
            continue;
        }

        $out[] = $line;
    }

    // Remove empty PSR-4 length/dir blocks left with only the 'P' wrapper when
    // the nested package was the sole PSR-4 entry.
    $joined = implode("\n", $out);
    $joined = preg_replace(
        "/public static \\\$prefixLengthsPsr4 = array \\(\\s*'P' =>\\s*array \\(\\s*\\),\\s*\\);/s",
        'public static $prefixLengthsPsr4 = array ();',
        $joined
    );
    $joined = preg_replace(
        "/public static \\\$prefixDirsPsr4 = array \\(\\s*\\);/s",
        'public static $prefixDirsPsr4 = array ();',
        $joined
    );
    $joined = preg_replace(
        "/return array\\(\\s*\\);/s",
        'return array();',
        $joined,
        1
    );

    file_put_contents($file, $joined);
}

deleteDirectory(__DIR__ . '/../lib/psr');
deleteDirectory(__DIR__ . '/../lib/pimple/pimple/src/Pimple');

// Legacy Strauss classmap (unused at runtime after 0.29) still points at deleted paths.
$legacyClassmap = __DIR__ . '/../lib/autoload-classmap.php';
if (file_exists($legacyClassmap)) {
    $legacy = file_get_contents($legacyClassmap);
    $legacy = str_replace('/src/Pimple/', '/src/PublishPress/Pimple/', $legacy);
    $legacy = str_replace("'/Versions.php'", "'/VersionLoader.php'", $legacy);
    $legacy = str_replace(
        "'PublishPress\\PimplePimple\\Versions'",
        "'PublishPress\\PimplePimple\\VersionLoader'",
        $legacy
    );
    file_put_contents($legacyClassmap, $legacy);
}

stripPsrContainerFromPhpMap(__DIR__ . '/../lib/autoload-classmap.php');
stripPsrContainerFromPhpMap(__DIR__ . '/../lib/composer/autoload_classmap.php');
stripPsrContainerFromPhpMap(__DIR__ . '/../lib/composer/autoload_psr4.php');
stripPsrContainerFromPhpMap(__DIR__ . '/../lib/composer/autoload_static.php');
stripPsrContainerFromPhpMap(__DIR__ . '/../lib/composer/autoload_namespaces.php');
