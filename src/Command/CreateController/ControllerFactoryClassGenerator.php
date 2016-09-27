<?php
declare (strict_types = 1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
