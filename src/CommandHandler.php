<?php
declare (strict_types=1);
/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

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

    /**
     * Handle the CLI arguments.
     *
     * @param array $arguments
     * @return int
     */
    public function __invoke(array $arguments):int
    {
//        $help = new Help();
        // Called without arguments
        if (count($arguments) < 1) {
            fwrite(STDERR, 'No arguments provided.' . PHP_EOL . PHP_EOL);
            $help(STDERR);
            return 1;
        }

    }

    private function commandNameFormat($string):string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

}
