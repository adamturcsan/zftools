<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace Legow\ZFTools\Command;

use LegoW\ZFTools\CommandInterface;
use LegoW\ZFTools\Utils;
/**
 * Description of CreateModule
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CreateModule implements CommandInterface
{
    private $availableOptions = [
        'name' => 'required'
    ];
    
    private $options = [];
    
    private $errorInfo = [];
    
    private $moduleClassTemplate = 'Module.tpl';
    
    private $indexControllerClassTemplate = 'IndexController.tpl';
    private $moduleConfigTempalte = 'module.config.tpl';
    
    public function feed($argument)
    {
        foreach($this->availableOptions as $name => $isRequired) {
            if(!array_key_exists($name, $this->options)) {
                $this->options[$name] = $argument;
                return;
            }
        }
    }

    public function isValid()
    {
        $valid = true;
        foreach($this->availableOptions as $name => $isRequired) {
            if($isRequired && !array_key_exists($name, $this->options)) {
                $valid = false;
                $this->errorInfo[] = 'Option \''.$name.'\' is required.';
            }
        }
        return $valid;
    }

    public function run()
    {
        if(!class_exists('\\Zend\\ModuleManager\\ModuleManager')) {
            throw new \Exception("Not in a Zend Framework project");
        }
        return $this->createModule($this->options["name"]);
    }

    public function errorInfo()
    {
        foreach($this->errorInfo as $msg) {
            echo $msg.PHP_EOL;
        }
        return 1;
    }
    
    public function createModule($name)
    {
        $defaultWD = getcwd();
        chdir('../');
        $templates = $this->fetchTemplatesFor($name);
        if(basename(getcwd()) == 'vendor' || is_dir('../module')) {
            mkdir('../module/'.$name, 0776, true);
            chdir('../module/'.$name);
        } elseif (basename(getcwd()) == 'zf-tools') { //for develop pruposes
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
    }
    
    private function fetchTemplatesFor($name)
    {
        $templates = [];
        $templates['moduleClass'] = sprintf(file_get_contents('src/code-templates/'.$this->moduleClassTemplate), $name);
        $templates['controller'] = sprintf(file_get_contents('src/code-templates/'.$this->indexControllerClassTemplate), $name);
        $templates['moduleConfig'] = sprintf(file_get_contents('src/code-templates/'.$this->moduleConfigTempalte), $name);
        return $templates;
    }
    
    private function addToModulesList($name)
    {
        $modulesConfig = '../../config/modules.config.php';
        $modules = include $modulesConfig;
        $modules[] = $name;
        $fileContent = file_get_contents($modulesConfig);
        preg_match('/\/\*\*[\n\r\s\t\*@\w:\/\.\(\)-]+\*\//i', $fileContent, $matches);
        var_dump($matches);
        file_put_contents($modulesConfig, "<?php\n\n".array_shift($matches)."\n\nreturn ".Utils::arrayExport($modules).";");
    }
}
