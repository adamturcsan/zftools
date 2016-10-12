<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Test;

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Description of TestEnvironment
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
        self::$timeHash = md5(time() . 'CreateModuleTest');
        $root = self::$timeHash . '/UnitTest/';
        mkdir($root . 'module', 0775, true);
        mkdir($root . 'vendor/legow/zf-tools/bin', 0775, true);
        self::initComposer($root);
        chdir($root . 'vendor/legow/zf-tools/bin');
    }

    public static function removeTestEnvironment()
    {
        chdir(self::$defaultWD);
        $workDir = self::$timeHash;
        if (is_dir($workDir)) {
            system('rm -R ' . $workDir);
        }
    }
    
    private static function initComposer($root)
    {
        putenv('COMPOSER_HOME='.getcwd().'/../vendor/bin/composer');
        $cwd = getcwd();
        chdir($root);
        $input = new ArrayInput(['command' => 'init', '--no-interaction']);
        $application = new Application();
        $application->setAutoExit(false); // prevent `$application->run` method from exitting the script
        $exitCode = $application->run($input);
        chdir($cwd);
        return $exitCode;
    }

}
