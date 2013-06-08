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
namespace Phramz\Commons\Test\Collection;

use Phramz\Commons\Collection\QuickSort;
use Phramz\Commons\Number\NumericComparator;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\Collection\QuickSort<extended>
 */
class QuickSortTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function testSortArray()
    {
        $comparator = new NumericComparator();
        $test = array(7,3,5,7,-56,-4,2,23,4,6,8,93,-2,6,-21,5,5,5,0);
        $expectation = array (-56, -21, -4, -2, 0, 2, 3, 4, 5, 5, 5, 5, 6, 6, 7, 7, 8, 23, 93);
        $quicksort = new QuickSort();

        $result = $quicksort->sortArray($test, $comparator);
        $this->assertEquals($expectation, $result);
    }
}
