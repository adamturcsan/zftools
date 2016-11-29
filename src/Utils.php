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
 * Description of Utils
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Utils
{
    public static function arrayExport(array $array): string
    {
        $arrayString = '[';
        $isAssoc = self::isAssoc($array);
        foreach($array as $key => $value) {
            $arrayString .= "\n    ";
            if($isAssoc) {
                $arrayString .= "'".$key."' => ";
            }
            $arrayString .= is_array($value) ? self::arrayExport($value) : self::typeExport($value);
            $arrayString .= ',';
        }
        $arrayString .= "\n]";
        return $arrayString;
    }
    
    public static function typeExport($value)
    {
        if(is_int($value) || is_double($value)) {
            return $value;
        } elseif(is_string($value)) {
            return "'$value'";
        } elseif(is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        throw new \InvalidArgumentException('Not handled type recieved');
    }
    
    public static function isAssoc(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
