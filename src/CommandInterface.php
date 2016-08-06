<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

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
    public function isValid();
    
    public function errorInfo();
}
