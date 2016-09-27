<?php
declare (strict_types=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LegoW\ZFTools\Command\CreateModule;

use LegoW\ZFTools\Command\CreateController\ControllerFactoryClassGenerator;

/**
 * Description of IndexControllerFactoryClassGenerator
 *
 * @author junior
 */
class IndexControllerFactoryClassGenerator extends ControllerFactoryClassGenerator
{
    public function __construct(string $namespace)
    {
        $controllerName = 'Index';
        parent::__construct($namespace, $controllerName);
    }
}
