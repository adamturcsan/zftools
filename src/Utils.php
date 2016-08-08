<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\ZFTools;

/**
 * Description of Utils
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Utils
{
    public static function arrayExport(array $array)
    {
        $op = "[";
        if(!self::isAssoc($array)) {
            foreach ($array as $value) {
                $op.= "\n    ";
                if(is_array($value)) {
                    $op .= self::arrayExport($value).',';
                } else {
                    $op .= self::typeExport($value).', ';
                }
            }
        } else {
            foreach($array as $key => $value)
            {
                $op.= "\n    ";
                if(is_array($value)) {
                    $op .= self::arrayExport($value).',';
                } else {
                    $op .= "'".$key."' => ".self::typeExport($value).',';
                }
            }
        }
        $op .= "\n]";
        return $op;
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
