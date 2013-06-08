<?php
/**
 * Copyright 2011-2013 Maximilian Reichel <mr@phramz.com>
 *
 * This file is part of Phramz.
 *
 * Phramz is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phramz is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Phramz. If not, see <http://www.gnu.org/licenses/lgpl.txt>.
 */
namespace Phramz\Commons\Test\Number;

use Phramz\Commons\Api\Comparable;
use Phramz\Commons\Number\NumericComparator;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\Number\NumericComparator<extended>
 */
class NumericComparatorTest extends AbstractTestCase
{
    /**
     * @expectedException \LogicException
     */
    public function testCompareLogicException()
    {
        $comparator = new NumericComparator();
        $comparator->compare(array(), 0);
    }

    /**
     * @test
     * @dataProvider compareDataProvider
     */
    public function testCompare($left, $right, $expected)
    {
        $comparator = new NumericComparator();
        $this->assertEquals($expected, $comparator->compare($left, $right));
    }

    public function compareDataProvider()
    {
        return array(
            array(0, 0, Comparable::EQUALS),
            array(1, 1, Comparable::EQUALS),
            array(-1, -1, Comparable::EQUALS),
            array(0.01, 0.01, Comparable::EQUALS),
            array(1.01, 1.01, Comparable::EQUALS),
            array(-1.01, -1.01, Comparable::EQUALS),
            array("0", "0", Comparable::EQUALS),
            array("1", "1", Comparable::EQUALS),
            array("-1", "-1", Comparable::EQUALS),
            array(-1, 0, Comparable::LESS_THAN),
            array(1, 10, Comparable::LESS_THAN),
            array(-11, -10, Comparable::LESS_THAN),
            array(0, -1, Comparable::GREATER_THAN),
            array(10, 1, Comparable::GREATER_THAN),
            array(-10, -11, Comparable::GREATER_THAN)
        );
    }
}
