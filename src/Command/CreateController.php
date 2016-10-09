<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

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

    public function run(): int
    {
        if (!class_exists('\\Zend\\ModuleManager\\ModuleManager')) {
            throw new \Exception("Not in a Zend Framework project");
        }
//        if(!$this->moduleExists($this->options['module'])) {
//            throw new \Exception("Module does not exist");
//        }
        if ($this->createController($this->options['module'],
                        $this->options['name'])) {
            return 0;
        }
        return 1;
    }

    public function createController(string $moduleName,
            string $controllerName): bool
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
        return true;
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
