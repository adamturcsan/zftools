<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 *
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare(strict_types=1);

namespace LegoW\ZFTools\Command\CreateModule;

use LegoW\ZFTools\Command\CreateController\ControllerClassGenerator;

/**
 * Description of IndexControllerClassGenerator.
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
