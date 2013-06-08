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
namespace Phramz\Commons\Number;

use Phramz\Commons\Api\Comparable;
use Phramz\Commons\Api\Comparator;

class NumericComparator implements Comparator
{
    /**
     * (non-PHPdoc)
     * @see Comparator::compare()
     */
    public function compare($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            throw new \LogicException("unable to compare non-numeric values!");
        }

        if ($left == $right) {
            return Comparable::EQUALS;
        }

        return $left > $right ? Comparable::GREATER_THAN : Comparable::LESS_THAN;
    }
}
