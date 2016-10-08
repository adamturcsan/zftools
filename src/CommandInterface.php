<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools;

/**
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
interface CommandInterface
{

    /**
     * @param mixed $argument
     */
    public function feed($argument);

    public function run();

    /**
     * @return boolean
     */
    public function isValid():bool;
    
    public function errorInfo():int;
}
