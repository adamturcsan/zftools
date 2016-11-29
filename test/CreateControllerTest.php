<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Test;

use LegoW\ZFTools\Test\TestEnvironment;
use LegoW\ZFTools\Command\{
    CreateModule,
    CreateController,
    CreateController\ModuleNotExistsException
};
/**
 * Description of CreateControllerTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CreateControllerTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @beforeClass
     */
    public static function setUpTestEnvironment()
    {
        TestEnvironment::setUpEnvironment();
        $createModule = new CreateModule();
        $createModule->createModule('testName');
    }
    
    /**
     * @afterClass
     */
    public static function removeTestEnvironment()
    {
        TestEnvironment::removeTestEnvironment();
    }
    
    public function testValidityCheckAndConfiguration()
    {
        $createController = new CreateController();
        $this->assertFalse($createController->isValid());
        $createController->feed('testName');
        $this->assertFalse($createController->isValid());
        $createController->feed('testController');
        $this->assertTrue($createController->isValid());
        $exception = null;
        try {
            $createController->feed('UnnecessaryArgument');
        } catch (\Exception $ex) {
            $exception = $ex;
        }
        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
        return $createController;
    }
    
    public function testErrorInfo()
    {
        $createController = new CreateController();
        $createController->isValid();
        $this->assertEquals(1, $createController->errorInfo());
    }
    
    public function testCreateController()
    {
        $createController = new CreateController();
        $moduleName = 'testName';
        $controllerName = 'Test';
        $this->assertTrue($createController->createController($moduleName, $controllerName));
    }
    
    /**
     * @depends testValidityCheckAndConfiguration
     */
    public function testRun(CreateController $createController)
    {
        $exception = null;
        try{
            $failingCreateController = new CreateController();
            $failingCreateController->feed('NonexistentModule');
            $failingCreateController->feed('Test');
            $failingCreateController->run();
        } catch (\Exception $ex) {
            $exception = $ex;
        }
        $this->assertInstanceOf(ModuleNotExistsException::class, $exception);
        $this->assertEquals(0, $createController->run());
    }
}
