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
    ModuleConfigGenerator,
    ModuleNotExistsException
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
        if (!$this->moduleExists($this->options['module'])) {
            throw new ModuleNotExistsException("Module does not exist");
        }
        if ($this->createController($this->options['module'],
                        $this->options['name'])) {
            return 0;
        }
        return 1;
    }

    public function createController(string $moduleName, string $controllerName): bool
    {
        $defaultWD = $this->changeToRoot();
        chdir('../module/' . $moduleName);
        if (!is_dir('src/Controller')) {
            mkdir('src/Controller', 0775, true);
        }
        chdir('src/Controller');
        $this->generateControllerFiles($moduleName, $controllerName);
        $this->addControllerToModuleConfig($controllerName);
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

    protected function addControllerToModuleConfig(string $controllerName)
    {
        chdir('../..');
        if (is_file('config/module.config.php')) {
            $configGenerator = new ModuleConfigGenerator($controllerName);
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
        $defaultWD = $this->changeToRoot();
        $moduleFile = '../module/' . $moduleName . '/src/Module.php';
        if (is_file($moduleFile)) {
            include_once $moduleFile;
        }
        chdir($defaultWD);
        return class_exists($moduleName . '\\Module');
    }

}
