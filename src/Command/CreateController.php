<?php

declare (strict_types = 1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LegoW\ZFTools\Command;

use LegoW\ZFTools\Command\CreateController\{
    ControllerClassGenerator,
    ControllerFactoryClassGenerator,
    ModuleConfigGenerator
};

/**
 * Description of CreateController
 *
 * @author junior
 */
class CreateController extends AbstractCommand
{

    protected $availableOptions = [
        'module' => 'required',
        'name' => 'required'
    ];
    protected $options = [];
    protected $errorInfo = [];

    public function run()
    {
        if (!class_exists('\\Zend\\ModuleManager\\ModuleManager')) {
            throw new \Exception("Not in a Zend Framework project");
        }
//        if(!$this->moduleExists($this->options['module'])) {
//            throw new \Exception("Module does not exist");
//        }
        $this->createController($this->options['module'], $this->options['name']);
    }

    protected function createController(string $moduleName,
            string $controllerName)
    {
        $defaultWD = $this->changeToRoot();
        if (basename(getcwd()) == 'vendor' || is_dir('../module')) {
            chdir('../module/' . $moduleName);
        } elseif (chdir($defaultWD . '/../') && basename(getcwd()) == 'zfTools') { //for develop pruposes
            if (!is_dir('module')) {
                mkdir('module/' . $moduleName, 0775, true);
            }
            chdir('module/' . $moduleName);
        }
        if (!is_dir('src/Controller')) {
            mkdir('src/Controller', 0775, true);
        }
        chdir('src/Controller');
        $this->generateControllerFiles($moduleName, $controllerName);
        $this->addControllerToModuleConfig($moduleName, $controllerName);
        chdir($defaultWD);
    }

    protected function generateControllerFiles(string $moduleName,
            string $controllerName): bool
    {
        $contollerGenerator = new ControllerClassGenerator($moduleName,
                $controllerName);
        file_put_contents($controllerName . 'Controller.php',
                $contollerGenerator->generate());
        $factoryGenerator = new ControllerFactoryClassGenerator($moduleName,
                $controllerName);
        file_put_contents($controllerName . 'ControllerFactory.php',
                $factoryGenerator->generate());
        return true;
    }

    protected function addControllerToModuleConfig(string $moduleName,
            string $controllerName)
    {
        chdir('../..');
        if (is_file('config/module.config.php')) {
            $configGenerator = new ModuleConfigGenerator($moduleName,
                    $controllerName);
            file_put_contents('config/module.config.php',
                    $configGenerator->generate());
        }
    }

    /**
     * 
     * @param string $moduleName
     * @return bool
     */
    protected function moduleExists(string $moduleName): bool
    {
        return class_exists($moduleName . '\\Module');
    }

}
