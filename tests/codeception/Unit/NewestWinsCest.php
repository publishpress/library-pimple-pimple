<?php

use PublishPress\PimplePimple\VersionLoader;

class NewestWinsCest
{
    public function _before()
    {
        require_once dirname(__DIR__, 3) . '/lib/VersionLoader.php';
    }

    public function testRegisterAndLatestVersion(UnitTester $I)
    {
        $loader = new VersionLoader();

        $I->assertTrue($loader->register('1.0.0', 'callback_one'));
        $I->assertTrue($loader->register('2.0.0', 'callback_two'));
        $I->assertTrue($loader->register('1.5.0', 'callback_three'));
        $I->assertFalse($loader->register('2.0.0', 'callback_ignored'));

        $I->assertEquals('2.0.0', $loader->latestVersion());
        $I->assertEquals('callback_two', $loader->latestVersionCallback());
    }

    public function testEmptyRegistry(UnitTester $I)
    {
        $loader = new VersionLoader();

        $I->assertFalse($loader->latestVersion());
        $I->assertEquals('__return_null', $loader->latestVersionCallback());
    }

    public function testVersionsIsAnAliasOfVersionLoader(UnitTester $I)
    {
        $I->assertSame(
            VersionLoader::class,
            (new ReflectionClass('PublishPress\\PimplePimple\\Versions'))->getName()
        );
    }
}
