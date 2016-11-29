<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Test;

use LegoW\ZFTools\Command\CreateController\ControllerClassGenerator;
use Zend\Code\Generator\{
    DocBlockGenerator,
    MethodGenerator
};

/**
 * Description of ControllerClassGeneratorTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ControllerClassGeneratorTest extends \PHPUnit_Framework_TestCase
{
    
    public function testConstruct()
    {
        $typeError = null;
        try {
            new ControllerClassGenerator();
        } catch (\Throwable $er) {
            $typeError = $er;
        }
        $this->assertInstanceOf(\TypeError::class, $typeError, 'Empty constructor');
        
        try {
            new ControllerClassGenerator(['Test', 'Test']);
        } catch (\Throwable $er) {
            $typeError = $er;
        }
        $this->assertInstanceOf(\TypeError::class, $typeError);
        
        $generator = new ControllerClassGenerator('Test', 'Test');
        $this->assertInstanceOf(ControllerClassGenerator::class, $generator);
        return $generator;
    }
    
    /**
     * @depends testConstruct
     * @param ControllerClassGenerator $generator
     */
    public function testGetDocBlock(ControllerClassGenerator $generator)
    {
        try {
            $generator->getControllerDocBlock();
        } catch (\Throwable $er) {
            $this->assertInstanceOf(\TypeError::class, $er);
        }
        
        $docBlockGenerator = $generator->getControllerDocBlock('Test');
        $this->assertInstanceOf(DocBlockGenerator::class, $docBlockGenerator);
        
        $shortDesc = $docBlockGenerator->getShortDescription();
        $this->assertContains('TestController', $shortDesc);
        
        $longDesc = $docBlockGenerator->getLongDescription();
        $this->assertContains('LegoW\\ZFTools', $longDesc);
    }
    
    /**
     * @depends testConstruct
     * @param ControllerClassGenerator $generator
     */
    public function testGetMethods(ControllerClassGenerator $generator)
    {
        $this->assertTrue(is_array($generator->getMethods()));
        /* @var $methodGenerator MethodGenerator */
        foreach($generator->getMethods() as $methodGenerator) {
            $this->assertInstanceOf(MethodGenerator::class, $methodGenerator);
            
            $name = $methodGenerator->getName();
            $this->assertContains('Action', $name);
        }
    }
}
