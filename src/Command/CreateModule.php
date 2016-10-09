<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Command;

use LegoW\ZFTools\Utils;
use LegoW\ZFTools\Command\CreateModule\{
    ModuleClassGenerator,
    IndexControllerClassGenerator,
    IndexControllerFactoryClassGenerator,
    ModuleConfigGenerator
};

/**
 * Description of CreateModule
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CreateModule extends AbstractCommand
{

    protected $availableOptions = [
        'name' => 'required'
    ];
    protected $options = [];
    protected $errorInfo = [];

    public function run(): int
    {
        if ($this->createModule($this->options["name"])) {
            return 0;
        }
        return 1;
    }

    public function createModule(string $name): bool
    {
        $defaultWD = $this->changeToRoot();
        if (!is_dir('../module' . $name)) {
            mkdir('../module/' . $name, 0775, true);
        }
        chdir('../module/' . $name);
        mkdir('config', 0775);
        mkdir('src/Controller', 0775, true);
        $this->createModuleClassFile($name);
        $this->createIndexControllerFiles($name);
        $this->createModuleConfigGenerator($name);
        $this->addToModulesList($name);
        chdir($defaultWD);
        $this->addModuleToComposerAutoload($name);
        return true;
    }

    /**
     * @param string $name Module name
     * @return bool
     */
    private function createModuleClassFile(string $name): bool
    {
        $moduleClassGenerator = new ModuleClassGenerator($name);
        file_put_contents('src/Module.php', $moduleClassGenerator->generate());
        chmod('src/Module.php', 0775);
        return true;
    }

    /**
     * @param string $name Module name
     * @return bool
     */
    private function createIndexControllerFiles(string $name): bool
    {
        $controllerClassGenerator = new IndexControllerClassGenerator($name . '\\Controller');
        file_put_contents('src/Controller/IndexController.php',
                $controllerClassGenerator->generate());
        chmod('src/Controller/IndexController.php', 0775);
        $factoryClassGenerator = new IndexControllerFactoryClassGenerator($name . '\\Controller');
        file_put_contents('src/Controller/IndexControllerFactory.php',
                $factoryClassGenerator->generate());
        chmod('src/Controller/IndexControllerFactory.php', 0775);
        return true;
    }

    /**
     * @param string $name Module name
     * @return bool
     */
    private function createModuleConfigGenerator(string $name): bool
    {
        $moduleConfigGenerator = new ModuleConfigGenerator($name);
        file_put_contents('config/module.config.php',
                $moduleConfigGenerator->generate());
        chmod('config/module.config.php', 0775);
        return true;
    }

    private function addToModulesList(string $name)
    {
        $modulesConfig = '../../config/modules.config.php';
        if (!is_file($modulesConfig)) {
            if (!is_dir('../../config')) {
                mkdir('../../config', 0775, true);
            }
            touch($modulesConfig);
            $modules = [];
        } else {
            $modules = include $modulesConfig;
        }
        $modules[] = $name;
        $fileContent = file_get_contents($modulesConfig);
        $matches = [];
        preg_match('/\/\*\*[\n\r\s\t\*@\w:\/\.\(\)-]+\*\//i', $fileContent,
                $matches);
        file_put_contents($modulesConfig,
                "<?php\n\n" . array_shift($matches) . "\n\nreturn " . Utils::arrayExport($modules) . ";");
    }

    private function addModuleToComposerAutoload(string $name)
    {

        $defaultWD = $this->changeToRoot();
        if (is_file('../composer.json')) {
            $composerJson = json_decode(file_get_contents('../composer.json'));
            $autoload = $composerJson->autoload ?? new \stdClass();
            $psr4 = $autoload->{'psr-4'} ?? new \stdClass();
            $psr4->{$name . '\\'} = 'module/' . $name . '/src/';
            $autoload->{'psr-4'} = $psr4;
            $composerJson->autoload = $autoload;
            file_put_contents('../composer.json',
                    json_encode($composerJson,
                            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        chdir($defaultWD);
    }

}
