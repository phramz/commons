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
namespace Phramz\Commons\Api;

interface Comparator
{
    const EQUALS = 0;
    const LESS_THAN = -1;
    const GREATER_THAN = 1;

    /**
     * Returns a negative integer, zero, or a positive integer as $left
     * is less than, equal to, or greater than $right
     *
     * @param mixed $left
     * @param mixed $right
     * @return integer
     */
    public function compare($left, $right);
}
