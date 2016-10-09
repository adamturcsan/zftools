<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Test;

use LegoW\ZFTools\CommandHandler;

/**
 * Description of CommandHandlerTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @beforeClass
     */
    public static function setUpEnvironment()
    {
        TestEnvironment::setUpEnvironment();
    }
    
    /**
     * @afterClass
     */
    public static function removeEnvironment()
    {
        TestEnvironment::removeTestEnvironment();
    }
    
    public function testConstruct()
    {
        $exception = null;
        try {
            new CommandHandler();
        } catch (\Exception $ex) {
            $exception = $ex;
            $this->assertInstanceOf(\InvalidArgumentException::class, $ex, 'Invalid argument was thrown during empty constructor call');
        }
        $this->assertNotNull($exception, 'Exception was thrown during empty constructor call');
        $commandHandler = new CommandHandler(['create-module']);
        $this->assertInstanceOf(CommandHandler::class, $commandHandler);
        return $commandHandler;
    }
    
    /**
     * @depends testConstruct
     */
    public function testDispatch(CommandHandler $commandHandler)
    {
        $this->assertEquals(1, $commandHandler->dispatchCommand());
        $args = [
            'create-module',
            'testDispatch'
        ];echo getcwd().PHP_EOL;
        $createModuleHandler = new CommandHandler($args);
        $this->assertEquals(0, $createModuleHandler->dispatchCommand());
    }
}
