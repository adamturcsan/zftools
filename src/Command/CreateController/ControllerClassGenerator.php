<?php
declare (strict_types=1);
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
 * Description of ControllerGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ControllerClassGenerator extends FileGenerator
{

    public function __construct(string $namespace, string $controllerName)
    {
        $options = [
            'classes' => [
                new \Zend\Code\Generator\ClassGenerator(
                        $controllerName . 'Controller', $namespace, null,
                        'Zend\\Mvc\\Controller\\AbstractActionController', [],
                        [], $this->getMethods(),
                        $this->getControllerDocBlock($controllerName)
                )
            ],
            'uses' => [
                'Zend\\Mvc\\Controller\\AbstractActionController',
                'Zend\\View\\Model\\ViewModel'
            ]
        ];
        parent::__construct($options);
    }

    public function getMethods(): array
    {
        return [
            new MethodGenerator(
                    'indexAction', [], [], 'return new ViewModel();'
            )
        ];
    }

    public function getControllerDocBlock(string $controllerName): DocBlockGenerator
    {
        return new DocBlockGenerator('Example '.$controllerName.'Controller',
                'Class generated with LegoW\\ZFTools');
    }

}
