<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Test;

use LegoW\ZFTools\Command\CreateModule;

/**
 * Description of CreateModuleTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CreateModuleTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @beforeClass
     */
    public static function setUpTestEnvironment()
    {
        TestEnvironment::setUpEnvironment();
    }
    
    /**
     * @afterClass
     */
    public static function removeTestEnvironment()
    {
        TestEnvironment::removeTestEnvironment();
    }
    
    public function testConstruct()
    {
        $createModule = new CreateModule();
        $this->assertInstanceOf(CreateModule::class, $createModule);
    }
    
    public function testValidityCheckAndConfiguration()
    {
        $createModule = new CreateModule();
        $this->assertFalse($createModule->isValid());
        $createModule->feed('testName');
        $this->assertTrue($createModule->isValid());
        return $createModule;
    }
    
    public function testErrorInfo()
    {
        $createModule = new CreateModule();
        $createModule->isValid();
        $this->assertEquals(1, $createModule->errorInfo());
    }
    
    public function testCreateModule()
    {
        $createModule = new CreateModule();
        $name = 'testCreateModule';
        $this->assertTrue($createModule->createModule($name));
    }
    
    /**
     * @depends testValidityCheckAndConfiguration
     */
    public function testRun(CreateModule $createModule)
    {
        $this->assertEquals(0,$createModule->run());
    }
}
