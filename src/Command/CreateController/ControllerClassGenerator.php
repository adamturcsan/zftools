<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 *
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare(strict_types=1);

namespace LegoW\ZFTools\Command\CreateController;

use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;

/**
 * Description of ControllerGenerator.
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
                        $controllerName.'Controller', $namespace, null,
                        'Zend\\Mvc\\Controller\\AbstractActionController', [],
                        [], $this->getMethods(),
                        $this->getControllerDocBlock($controllerName)
                ),
            ],
            'uses' => [
                'Zend\\Mvc\\Controller\\AbstractActionController',
                'Zend\\View\\Model\\ViewModel',
            ],
        ];
        parent::__construct($options);
    }

    public function getMethods(): array
    {
        return [
            new MethodGenerator(
                    'indexAction', [], [], 'return new ViewModel();'
            ),
        ];
    }

    public function getControllerDocBlock(string $controllerName): DocBlockGenerator
    {
        return new DocBlockGenerator('Example '.$controllerName.'Controller',
                'Class generated with LegoW\\ZFTools');
    }
}
