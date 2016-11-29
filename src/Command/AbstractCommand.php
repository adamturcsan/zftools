<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

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
        foreach(array_keys($this->availableOptions) as $name) {
            if(!array_key_exists($name, $this->options)) {
                $this->options[$name] = $argument;
                return;
            }
        }
        throw new \InvalidArgumentException('This command cannot process this many arguments');
    }

    public function isValid():bool
    {
        $valid = true;
        $this->errorInfo = []; // Multiple check shouldn't multiply the lines
        foreach($this->availableOptions as $name => $isRequired) {
            if($isRequired && !array_key_exists($name, $this->options)) {
                $valid = false;
                $this->errorInfo[] = 'Option \''.$name.'\' is required.';
            }
        }
        return $valid;
    }

    abstract public function run() : int;

    public function errorInfo():int
    {
        foreach($this->errorInfo as $msg) {
            fputs(STDERR, $msg.PHP_EOL);
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
