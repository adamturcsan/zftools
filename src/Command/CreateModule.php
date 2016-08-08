<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools\Command;

use LegoW\ZFTools\CommandInterface;
use LegoW\ZFTools\Utils;
use LegoW\ZFTools\Command\CreateModule\{
    ModuleClassGenerator,
    IndexControllerClassGenerator,
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
        
    private $moduleConfigTempalte = 'module.config.tpl';
    
    public function run()
    {
        if(!class_exists('\\Zend\\ModuleManager\\ModuleManager')) {
            throw new \Exception("Not in a Zend Framework project");
        }
        return $this->createModule($this->options["name"]);
    }
    
    public function createModule($name)
    {
        $defaultWD = getcwd();
        chdir('../../../');
        $templates = $this->fetchTemplatesFor($name);
        if(basename(getcwd()) == 'vendor' || is_dir('../module')) {
            mkdir('../module/'.$name, 0776, true);
            chdir('../module/'.$name);
        } elseif (chdir($defaultWD.'/../') && basename(getcwd()) == 'zf-tools') { //for develop pruposes
            if(!is_dir('module')) {
                mkdir('module/'.$name,0776, true);
            }
            chdir('module/'.$name);
        }
        mkdir('config', 0776);
        mkdir('src/Controller', 0776, true);
        file_put_contents('src/Module.php', $templates['moduleClass']);
        file_put_contents('src/Controller/IndexController.php', $templates['controller']);
        file_put_contents('config/module.config.php', $templates['moduleConfig']);
        $this->addToModulesList($name);
        chdir($defaultWD);
        $this->addModuleToComposerAutoload($name);
    }
    
    /**
     * @todo Replace templates with zend-code codegeneration tool
     * @param string $name Desired module name
     * @return array
     */
    private function fetchTemplatesFor($name)
    {
        $templates = [];
        $moduleClassGenerator = new ModuleClassGenerator($name);
        $templates['moduleClass'] = $moduleClassGenerator->generate();
        $controllerClassGenerator = new IndexControllerClassGenerator($name.'\\Controller');
        $templates['controller'] = $controllerClassGenerator->generate();
        $moduleConfigGenerator = new ModuleConfigGenerator($name);
        $templates['moduleConfig'] = $moduleConfigGenerator->generate();
        return $templates;
    }
    
    private function addToModulesList($name)
    {
        $modulesConfig = '../../config/modules.config.php';
        $modules = include $modulesConfig;
        $modules[] = $name;
        $fileContent = file_get_contents($modulesConfig);
        preg_match('/\/\*\*[\n\r\s\t\*@\w:\/\.\(\)-]+\*\//i', $fileContent, $matches);
        file_put_contents($modulesConfig, "<?php\n\n".array_shift($matches)."\n\nreturn ".Utils::arrayExport($modules).";");
    }
    
    private function addModuleToComposerAutoload($name)
    {
        
        $defaultWD = getcwd();
        chdir('../../../');
        if(basename(getcwd()) == 'vendor' || is_file('../composer.json')) {
            $composerJson = json_decode(file_get_contents('../composer.json'));
            $composerJson['autoload']['psr-4'][$name.'\\'] = 'module/'.$name.'/src/';
            file_put_contents('../composer.json', json_decode($composerJson, JSON_PRETTY_PRINT));
        }
        chdir($defaultWD);
    }
}
