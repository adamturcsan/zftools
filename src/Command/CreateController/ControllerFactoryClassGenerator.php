<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Command\CreateController;

use Zend\Code\Generator\{
    FileGenerator,
    ClassGenerator,
    MethodGenerator,
    DocBlockGenerator
};

/**
 * Description of ControllerFactoryClassGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ControllerFactoryClassGenerator extends FileGenerator
{

    public function __construct(string $namespace, string $controllerName)
    {
        $options = [
            'classes' => [
                new ClassGenerator($controllerName . 'ControllerFactory',
                        $namespace, null, null, ['\Zend\\ServiceManager\\Factory\\FactoryInterface'], [],
                        $this->getMethods($controllerName),
                        $this->getFactoryDocBlock($controllerName)),
            ],
            'uses' => [
                'Zend\\Mvc\\Controller\\AbstractActionController',
                'Zend\\View\\Model\\ViewModel',
                'Zend\\ServiceManager\\Factory\\FactoryInterface'
            ]
        ];
        parent::__construct($options);
    }

    private function getMethods(string $controllerName): array
    {
        return [
            new MethodGenerator(
                    '__invoke',
                    [
                        [
                            'name' => 'container',
                            'type' => '\\Interop\\Container\\ContainerInterface'
                        ],
                        'requestedName',
                            [
                            'name' => 'options',
                            'type' => 'array',
                            'defaultvalue' => null
                        ]
                    ], 'public', 'return new '.$controllerName.'Controller();'
            )
        ];
    }

    private function getFactoryDocBlock(string $controllerName): DocBlockGenerator
    {
        return new DocBlockGenerator();
    }

}
