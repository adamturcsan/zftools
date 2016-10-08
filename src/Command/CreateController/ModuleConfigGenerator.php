<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Command\CreateController;

/**
 * Description of ModuleConfigGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ModuleConfigGenerator extends \Zend\Code\Generator\FileGenerator
{

    public function __construct(string $namespace, string $controllerName)
    {
        $filePath = 'config/module.config.php';

        $fileReflection = new \Zend\Code\Reflection\FileReflection($filePath,
                true);

        $fileBody = preg_replace('/<\?php/', '',$fileReflection->getContents());
        $strippedBody = preg_replace('/[\n\s]*(namespace)/', "$1", $fileBody);
        $finalBody = preg_replace('/(\'controllers\'\s*=>\s*\[[\s\n]*\'factories\'\s*=>\s* \[)/',
                "$1\n            Controller\\" . $controllerName . 'Controller::class => Controller\\' . $controllerName . 'ControllerFactory::class,',
                $strippedBody);

        parent::__construct([]);
        $this->setBody($finalBody);
    }

}
