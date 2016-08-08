<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace Legow\ZFTools\Command;

use LegoW\ZFTools\CommandInterface;
/**
 * Description of AbstractCommand
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
abstract class AbstractCommand implements CommandInterface
{
    protected $availableOptions = [];
    
    protected $options = [];
    
    protected $errorInfo = [];
    
    public function feed($argument)
    {
        foreach($this->availableOptions as $name => $isRequired) {
            if(!array_key_exists($name, $this->options)) {
                $this->options[$name] = $argument;
                return;
            }
        }  
        die(var_dump($this->availableOptions, $this->options));
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

    abstract public function run();

    public function errorInfo()
    {
        foreach($this->errorInfo as $msg) {
            echo $msg.PHP_EOL;
        }
        return 1;
    }
    
}
