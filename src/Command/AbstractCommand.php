<?php
declare(strict_types=1);
/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools\Command;

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
    }

    public function isValid():bool
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

    public function errorInfo():int
    {
        foreach($this->errorInfo as $msg) {
            echo $msg.PHP_EOL;
        }
        return 1;
    }
    
    /**
     * Changes to project root
     * @return string Default working directory
     */
    protected function changeToRoot() : string
    {
        $defaultWD = getcwd();
        chdir('../../../');
        return $defaultWD;
    }
    
}
