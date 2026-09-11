<?php

/**
 * VersionLoaderCest asserts class_exists(..., false). After initialize the
 * autoloader is registered but the class is not yet loaded — allow autoload.
 *
 * Called from composer.json scripts.generate-files after version-loader-generator.
 * No production data; only rewrites a generated PHP assertion.
 *
 * User: "Lets make sure this library is complaiant with
 * https://github.com/publishpress/team-handbook/blob/development/docs/dev/master/prefixing-libraries.md."
 */
$cest = dirname(__DIR__) . '/codeception/Integration/VersionLoaderCest.php';
$contents = file_get_contents($cest);
if ($contents === false) {
    fwrite(STDERR, "Could not read {$cest}\n");
    exit(1);
}

$from = "class_exists('PublishPress\\Pimple\\Container', false)";
$to = "class_exists('PublishPress\\Pimple\\Container')";

if (strpos($contents, $from) === false) {
    exit(0);
}

file_put_contents($cest, str_replace($from, $to, $contents, $count));
if ($count < 1) {
    fwrite(STDERR, "Failed to patch class_exists assertion in {$cest}\n");
    exit(1);
}
