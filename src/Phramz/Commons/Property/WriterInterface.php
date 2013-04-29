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
namespace Phramz\Commons\Property;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
interface WriterInterface
{
    /**
     * Sets a value to an object or array by it property-path. Property-names
     * are seperated by a dot '.' e.g.
     * write(array('foo', 'bar'), 'bazz', array('foo' => array ('bar' => 'foobar!')))
     * => will return array('foo' => array ('bar' => 'bazz'))
     * write('array('1', 'bar'), 'foobar!', array(array('foo'), array('bar' => 'bazz!')))
     * => will return array(array('foo'), array('bar' => 'foobar!'))
     * The same goes for any kind of object by its getter or public properties.
     *
     * @param array $path The path to the roperty
     * @param mixed $value The new value to set
     * @param array|object $target The array or object to retrieve the value from
     * @return mixed The processed target
     */
    public function write(array $path, $value, $target);
}
