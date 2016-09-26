<?php
declare (strict_type=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LegoW\ZFTools\Command\CreateModule;

use Zend\Code\Generator\{
    FileGenerator,
    ClassGenerator,
    MethodGenerator,
    DocBlockGenerator
};

/**
 * Description of IndexControllerFactoryClassGenerator
 *
 * @author junior
 */
class IndexControllerFactoryClassGenerator extends FileGenerator
{
    public function __construct(string $namespace)
    {
        $options = [
            'classes' => [
                new ClassGenerator('IndexControllerFactory', $namespace, null, null, ['FactoryInterface'], [], $this->getMethods(), $this->getFactoryDocBlock()),
            ],
            'uses' => [
                'Zend\\Mvc\\Controller\\AbstractActionController',
                'Zend\\View\\Model\\ViewModel',
                'Zend\\ServiceManager\\Factory\\FactoryInterface'
            ]
        ];
        parent::__construct($options);
    }
    
    private function getMethods() : array
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
                    ],
                    'public',
                    'return new IndexController();'
            )
        ];
    }
    
    private function getFactoryDocBlock() : DocBlockGenerator
    {
        return new DocBlockGenerator(
                );
    }
}
