<?php

/*
 * LegoW\ZFTools (https://github.com/adamturcsan/zftools)
 * 
 * @copyright Copyright (c) 2014-2016 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 */

declare (strict_types = 1);

namespace LegoW\ZFTools\Test;

use LegoW\ZFTools\Utils;

/**
 * Description of UtilsTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class UtilsTest extends \PHPUnit_Framework_TestCase
{
    
    public function testArrayExport()
    {
        $assocArray = [
            'test'  => 'data',
            'lorem' => [
                'ipsum' => 1,
                'dolor' => true,
                'sit'   => 2.3
            ]
        ];
        $textAssocArray = "[
    'test' => 'data',
    'lorem' => [
    'ipsum' => 1,
    'dolor' => true,
    'sit' => 2.3,
],
]";
        $plainArray = [
            'lorem',
            'ipsum',
            [
                1,
                true,
                2.3
            ]
        ];
        $textPlainArray = "[
    'lorem',
    'ipsum',
    [
    1,
    true,
    2.3,
],
]";
        $this->assertEquals($textAssocArray, Utils::arrayExport($assocArray));
        $this->assertEquals($textPlainArray, Utils::arrayExport($plainArray));
    }
    
    public function testTypeExport()
    {
        $this->assertEquals('1',Utils::typeExport(1));
        $this->assertEquals('1.2',Utils::typeExport(1.2));
        $this->assertEquals("'everything's fine'",Utils::typeExport('everything\'s fine'));
        $this->assertEquals('true',Utils::typeExport(true));
        $this->assertEquals('false',Utils::typeExport(false));
        $exception = null;
        try {
            $this->assertEquals(null,Utils::typeExport([]));
        } catch(\Exception $ex) {
            $exception = $ex;
        }
        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
    }
}
