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
 * You should have received a copy of the GNU General Public License
 * along with Phramz.  If not, see <http://www.gnu.org/licenses/lgpl.txt>.
 */
namespace Phramz\Commons\Property;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
interface ReaderInterface
{
    /**
     * Retrives a value from an object or array by it property-path. Property-names
     * are seperated by a dot '.' e.g.
     * read(array('foo', 'bar'), array ('foo' => array ('bar' => 'foobar!')))
     * => will return 'foobar!'
     * read(array('1', 'bar'), array(array('foo'), array('bar' => 'bazz!')))
     * => will return 'bazz!'
     * The same goes for any kind of object by its getter or public properties.
     *
     * @param array $path The path to the roperty
     * @param array|object $target The array or object to retrieve the value from
     * @return mixed The value or NULL if the property not accessable
     */
    public function read(array $path, $target);
}
