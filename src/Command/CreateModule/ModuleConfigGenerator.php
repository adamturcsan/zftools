<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Command\CreateModule;

use Zend\Code\Generator\FileGenerator;
/**
 * Description of ModuleConfigGenerator
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ModuleConfigGenerator extends FileGenerator
{
    public function __construct(string $namespace)
    {
        parent::__construct([]);
        $this->setNamespace($namespace);
        $this->setBody(
'return [
    \'controllers\' => [
        \'factories\' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
        ],
    ]
];'
        );
    }
}
