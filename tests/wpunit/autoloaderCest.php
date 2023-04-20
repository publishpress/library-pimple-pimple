<?php

class autoloaderCest
{
    public function tryToTest(WpunitTester $I)
    {
        $I->assertTrue(class_exists('PublishPress\\Pimple\\Container'));
    }
}
