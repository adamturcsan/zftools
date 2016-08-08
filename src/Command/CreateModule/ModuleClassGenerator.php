<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools\Command\CreateModule;

use Zend\Code\Generator\{
    FileGenerator,
    ClassGenerator,
    MethodGenerator
};

/**
 * Description of ModuleClassGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ModuleClassGenerator extends FileGenerator
{
    /**
     * @var string
     */
    private $moduleName;
    
    public function __construct($moduleName, $options = null)
    {
        $this->moduleName = $moduleName;
        $options = [
            'classes' => [
                new ClassGenerator('Module', $moduleName, null, null, [], [], $this->getMethods(), $this->getModuleDocBlock())
            ]
        ];
        parent::__construct($options);
    }
    
    private function getMethods()
    {
        return [
            new MethodGenerator('getConfig', [], 'public', 'return include __DIR__ . \'/../config/module.config.php\';', null)
        ];
    }
    
    private function getModuleDocBlock()
    {
        return new \Zend\Code\Generator\DocBlockGenerator(
                'Module class for '.$this->moduleName,
                'Module \''.$this->moduleName.'\' is generated with LegoW\\ZFTools',
                []
                );
    }
}
