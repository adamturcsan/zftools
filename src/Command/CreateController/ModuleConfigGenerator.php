<?php

declare (strict_types = 1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LegoW\ZFTools\Command\CreateController;

/**
 * Description of ModuleConfigGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ModuleConfigGenerator extends \Zend\Code\Generator\FileGenerator
{

    public function __construct(string $namespace, string $controllerName)
    {
        $filePath = 'config/module.config.php';

        $fileReflection = new \Zend\Code\Reflection\FileReflection($filePath,
                true);

        $fileBody = preg_replace('/<\?php/', '',$fileReflection->getContents());
        $strippedBody = preg_replace('/[\n\s]*(namespace)/', "$1", $fileBody);
        $finalBody = preg_replace('/(\'controllers\'\s*=>\s*\[[\s\n]*\'factories\'\s*=>\s* \[)/',
                "$1\n            Controller\\" . $controllerName . 'Controller::class => Controller\\' . $controllerName . 'ControllerFactory::class,',
                $strippedBody);

        parent::__construct([]);
        $this->setBody($finalBody);
    }

}
