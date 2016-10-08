<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools;

class CommandHandler
{

    /**
     * @var array
     */
    private $argStack = [];

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = [])
    {
        if(count($arguments) == 0) {
            throw new \InvalidArgumentException("At least one parameter has to be given");
        }
        $this->argStack = $arguments;
    }

    /**
     * 
     */
    public function dispatchCommand()
    {
        $args = $this->argStack;
        $command = null;
        foreach ($args as $argument) {
            if ($command == null) {
                $command = $this->fetchCommand($argument);
            } else {
                $this->feedCommand($argument, $command);
            }
            array_shift($this->argStack);
        }
        if ($command->isValid()) {
            exit($this->runCommand($command));
        } else {
            exit($this->errorInfo($command));
        }
    }

    /**
     * 
     * @param string $name
     * @return CommandInterface
     * @throws \InvalidArgumentException
     */
    private function fetchCommand($name):CommandInterface
    {
        $className = 'LegoW\\ZFTools\\Command\\' . $this->commandNameFormat($name);
        if (class_exists($className)) {
            return new $className;
        }
        throw new \InvalidArgumentException("Unknown command: ".$name. " - Command implementation ".$className." does not exists.");
    }

    private function feedCommand($argument, CommandInterface &$command)
    {
        $command->feed($argument);
    }
    
    private function runCommand(CommandInterface $command)
    {
        exit($command->run());
    }
    
    private function errorInfo(CommandInterface $command)
    {
        exit($command->errorInfo());
    }

    private function commandNameFormat($string):string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

}
