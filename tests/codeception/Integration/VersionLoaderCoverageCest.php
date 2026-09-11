<?php

/**
 * Additional coverage for VersionLoader and prefixed Pimple classes.
 *
 * Note: VersionLoaderCest.php is auto-generated, so additional tests live here.
 */

use PublishPress\PimplePimple\VersionLoader;
use PublishPress\PimplePimple\Versions;

class VersionLoaderCoverageCest
{
    public function testDuplicateRegistrationPrevented(IntegrationTester $I)
    {
        $loader = VersionLoader::getInstance();

        $result = $loader->register('3.5.0.11', 'some_callback');

        $I->assertFalse($result, 'Duplicate registration should return false');
    }

    public function testVersionSortingWorksCorrectly(IntegrationTester $I)
    {
        $loader = VersionLoader::getInstance();

        $registeredVersions = $loader->getVersions();

        $latest = $loader->latestVersion();
        $allVersions = array_keys($registeredVersions);

        foreach ($allVersions as $version) {
            $I->assertTrue(
                version_compare($version, $latest, '<='),
                "Version {$version} should be <= latest version {$latest}"
            );
        }
    }

    public function testPimpleContainerExists(IntegrationTester $I)
    {
        $loader = VersionLoader::getInstance();
        $loader->initializeLatestVersion();

        $I->assertTrue(class_exists('PublishPress\Pimple\Container'));
        $I->assertTrue(class_exists('PublishPress\Pimple\Psr11\Container'));
    }

    public function testNestedPsrContainerComesFromPrefixedPackage(IntegrationTester $I)
    {
        $loader = VersionLoader::getInstance();
        $loader->initializeLatestVersion();

        $I->assertTrue(interface_exists('PublishPress\Psr\Container\ContainerInterface'));
        $I->assertFalse(is_dir(dirname(__DIR__, 3) . '/lib/psr'));
    }

    public function testUnprefixedPimpleIsNotLoaded(IntegrationTester $I)
    {
        $I->assertFalse(class_exists('Pimple\Container', false));
    }

    public function testSingletonPattern(IntegrationTester $I)
    {
        $instance1 = VersionLoader::getInstance();
        $instance2 = VersionLoader::getInstance();

        $I->assertSame($instance1, $instance2, 'getInstance should return the same instance');
    }

    public function testVersionsAliasSharesTheSameInstance(IntegrationTester $I)
    {
        $I->assertSame(
            VersionLoader::getInstance(),
            Versions::getInstance(),
            'Versions should alias VersionLoader so mixed copies share one registry'
        );
    }

    public function testVersionConstantsDefined(IntegrationTester $I)
    {
        $loader = VersionLoader::getInstance();
        $loader->initializeLatestVersion();

        $I->assertTrue(defined('PUBLISHPRESS_PIMPLE_PIMPLE_VERSION'));
        $I->assertEquals('3.5.0.11', PUBLISHPRESS_PIMPLE_PIMPLE_VERSION);

        $I->assertTrue(defined('PUBLISHPRESS_PIMPLE_PIMPLE_INCLUDED'));
    }
}
