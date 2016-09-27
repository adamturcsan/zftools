<?php
declare(strict_types=1);
/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools\Command\CreateModule;

use LegoW\ZFTools\Command\CreateController\ControllerClassGenerator;

/**
 * Description of IndexControllerClassGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class IndexControllerClassGenerator extends ControllerClassGenerator
{
    public function __construct(string $namespace)
    {
        $controllerName = 'Index';
        parent::__construct($namespace, $controllerName);
    }
}
