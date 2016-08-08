<?php
declare(strict_types=1);
/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

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
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ]
];'
        );
    }
}
