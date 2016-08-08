<?php
declare(strict_types=1);
/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools\Command\CreateModule;

use Zend\Code\Generator\{
    FileGenerator,
    ClassGenerator,
    MethodGenerator,
    DocBlockGenerator
};

/**
 * Description of IndexControllerClassGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class IndexControllerClassGenerator extends FileGenerator
{
    public function __construct(string $namespace)
    {
        $options = [
            'classes' => [
                new \Zend\Code\Generator\ClassGenerator('IndexController', $namespace, null, 'Zend\\Mvc\\Controller\\AbstractActionController', [], [], $this->getMethods(), $this->getControllerDocBlock())
            ],
            'uses' => [
                'Zend\\Mvc\\Controller\\AbstractActionController',
                'Zend\\View\\Model\\ViewModel'
            ]
        ];
        parent::__construct($options);
    }
    
    public function getMethods():array
    {
        return [
            new MethodGenerator(
                    'indexAction',
                    [],
                    [],
                    'return new ViewModel();'
                )
        ];
    }
    
    public function getControllerDocBlock():DocBlockGenerator
    {
        return new DocBlockGenerator('Example IndexController', 'Class generated with LegoW\\ZFTools');
    }
}
