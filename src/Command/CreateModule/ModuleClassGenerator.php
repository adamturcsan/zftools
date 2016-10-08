<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Command\CreateModule;

use Zend\Code\Generator\{
    FileGenerator,
    ClassGenerator,
    MethodGenerator,
    DocBlockGenerator
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
    
    public function __construct(string $moduleName)
    {
        $this->moduleName = $moduleName;
        $options = [
            'classes' => [
                new ClassGenerator('Module', $moduleName, null, null, [], [], $this->getMethods(), $this->getModuleDocBlock())
            ]
        ];
        parent::__construct($options);
    }
    
    private function getMethods():array
    {
        return [
            new MethodGenerator('getConfig', [], 'public', 'return include __DIR__ . \'/../config/module.config.php\';', null)
        ];
    }
    
    private function getModuleDocBlock():DocBlockGenerator
    {
        return new DocBlockGenerator(
                'Module class for '.$this->moduleName,
                'Module \''.$this->moduleName.'\' is generated with LegoW\\ZFTools',
                []
                );
    }
}
