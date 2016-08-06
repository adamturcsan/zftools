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
        if(class_exists('\\Zend\\ModuleManager\\ModuleManager')) {
            echo "Fasza";
        }
        throw new \Exception("Not in a Zend Framework project");
    }

    public function errorInfo()
    {
        foreach($this->errorInfo as $msg) {
            echo $msg.PHP_EOL;
        }
        return 1;
    }

//put your code here
}
