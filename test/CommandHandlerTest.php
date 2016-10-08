<?php

declare (strict_types = 1);
/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools;

/**
 * Description of CommandHandlerTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testConsturct()
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
    }
}
