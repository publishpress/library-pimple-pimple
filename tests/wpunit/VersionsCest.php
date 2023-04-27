<?php

/*****************************************************************
 * This file is generated on composer update command by
 * a custom script. 
 * 
 * Do not edit it manually!
 ****************************************************************/

use PublishPress\PimplePimple\Versions;

class VersionsCest
{
    public function testAllVersionsAreRegistered(WpunitTester $I)
    {
        $versions = Versions::getInstance();

        $registeredVersions = $versions->getVersions();

        $I->assertNotEmpty($registeredVersions);
        $I->assertEquals([
            '2.0.0.1' => 'PublishPress\PimplePimple\initialize2Dot0Dot0Dot1',
            '2.0.0.2' => 'PublishPress\PimplePimple\initialize2Dot0Dot0Dot2',
            '3.5.0.8' => 'PublishPress\PimplePimple\initialize3Dot5Dot0Dot8',
        ], $registeredVersions);
    }

    public function testLatestVersionIsTheCurrentVersion(WpunitTester $I)
    {
        $versions = Versions::getInstance();

        $latestVersion = $versions->latestVersion();

        $I->assertEquals('3.5.0.8', $latestVersion);
    }

    public function testLatestVersionCallbackIsTheLastOne(WpunitTester $I)
    {
        $versions = Versions::getInstance();

        $latestVersionCallback = $versions->latestVersionCallback();

        $I->assertEquals('PublishPress\PimplePimple\initialize3Dot5Dot0Dot8', $latestVersionCallback);
    }

    public function testInitializeLatestVersion(WpunitTester $I)
    {
        $versions = Versions::getInstance();

        $versions->initializeLatestVersion();

        $I->assertTrue(class_exists('PublishPress\Pimple\Container'));

        $didAction = (bool)did_action('publishpress_pimple_pimple_3Dot5Dot0Dot8_initialized');
        $I->assertTrue($didAction);
    }
}
