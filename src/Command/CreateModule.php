<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace Legow\ZFTools\Command;

use LegoW\ZFTools\CommandInterface;
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
    
    private $moduleClassTemplate = '<?php 

namespace %s;

class Module {
    public function getConfig()
    {
        return include __DIR__.\'/../config/module.config.php\';
    }
}
';
    private $indexControllerClassTemplate = '<?php 

namespace %s\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
';
    private $moduleConfigTempalte = '<?php 

namespace %s;

return [
    \'controllers\' => [
        \'factories\' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ]
];
';
    
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
        chdir('../');
        if(basename(getcwd()) == 'vendor' || is_dir('../module')) {
            //GOOD
        } elseif (basename(getcwd()) == 'zf-tools') { //for develop pruposes
            if(!is_dir('module')) {
                mkdir('module/'.$name,0776, true);
            }
            chdir('module/'.$name);
            mkdir('config', 0776);
            mkdir('src/Controller', 0776, true);
            $classDefinition = sprintf($this->moduleClassTemplate, $name);
            file_put_contents('src/Module.php', $classDefinition);
            $controllerDefinition = sprintf($this->indexControllerClassTemplate, $name);
            file_put_contents('src/Controller/IndexController.php', $controllerDefinition);
            $confgiDefinition = sprintf($this->moduleConfigTempalte, $name);
            file_put_contents('config/module.config.php', $confgiDefinition);
        }
    }
}
