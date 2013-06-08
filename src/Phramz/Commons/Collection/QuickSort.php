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
namespace Phramz\Commons\Collection;

use Phramz\Commons\Api\Comparator;
use Phramz\Commons\Api\Comparable;

class QuickSort
{
    public function sortArray(array $array, Comparator $comparator)
    {
        // no need to sort ?
        if (count($array) <= 1) {
            return $array;
        }

        $pivot = array_pop($array);
        $less = array();
        $greater = array();

        foreach ($array as $item) {
            if ($comparator->compare($item, $pivot) == Comparable::LESS_THAN) {
                $less[] = $item;
            } else {
                $greater[] = $item;
            }
        }

        return array_merge(
            $this->sortArray($less, $comparator),
            array($pivot),
            $this->sortArray($greater,$comparator)
        );
    }
}
