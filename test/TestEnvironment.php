<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 *
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare(strict_types=1);

namespace LegoW\ZFTools\Test;

/**
 * Description of TestEnvironment.
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class TestEnvironment
{
    private static $timeHash = null;
    private static $defaultWD = null;

    public static function setUpEnvironment()
    {
        self::$defaultWD = getcwd();
        self::$timeHash = md5(time().'CreateModuleTest');
        $root = self::$timeHash.'/UnitTest/';
        mkdir($root.'module', 0775, true);
        mkdir($root.'vendor/legow/zf-tools/bin', 0775, true);
        file_put_contents($root.'composer.json', '{"autoload":{"psr-4":{}}}');
        chdir($root.'vendor/legow/zf-tools/bin');
    }

    public static function removeTestEnvironment()
    {
        chdir(self::$defaultWD);
        $workDir = self::$timeHash;
        if (is_dir($workDir)) {
            system('rm -R '.$workDir);
        }
    }
}
