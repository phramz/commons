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
class PropertyUtils extends AbstractPropertyAccess
{
    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * constructor
     *
     * @param ReaderInterface $reader optional writer-injection
     * @param WriterInterface $writer optional reader-injection
     */
    public function __construct(ReaderInterface $reader = null, WriterInterface $writer = null)
    {
        $this->reader = $reader ? $reader : new Reader();
        $this->writer = $writer ? $writer : new Writer();
    }

    /**
     * Retrives a value from an object or array by it property-path. Property-names
     * are seperated by a dot '.' e.g.
     * getProperty('foo.bar, array ('foo' => array ('bar' => 'foobar!')))
     * => will return 'foobar!'
     * getProperty('1.bar', array(array('foo'), array('bar' => 'bazz!')))
     * => will return 'bazz!'
     * The same goes for any kind of object by its getter or public properties.
     *
     * @param string $propertyPath The path to the roperty
     * @param array|object $target The array or object to retrieve the value from
     * @return mixed The value or NULL if the property not accessable
     */
    public function getProperty($propertyPath, $target)
    {
        return $this->reader->read($this->parsePropertyPath($propertyPath), $target);
    }

    /**
     * Sets a value to an object or array by it property-path. Property-names
     * are seperated by a dot '.' e.g.
     * setProperty('foo.bar, 'bazz', array('foo' => array ('bar' => 'foobar!')))
     * => will return array('foo' => array ('bar' => 'bazz'))
     * setProperty('1.bar', 'foobar!', array(array('foo'), array('bar' => 'bazz!')))
     * => will return array(array('foo'), array('bar' => 'foobar!'))
     * The same goes for any kind of object by its getter or public properties.
     *
     * @param string $propertyPath The path to the roperty
     * @param mixed $value The new value to set
     * @param array|object $target The array or object to retrieve the value from
     * @return mixed The processed target
     */
    public function setProperty($propertyPath, $value, $target)
    {
        return $this->writer->write($this->parsePropertyPath($propertyPath), $value, $target);
    }

    /**
     * Returns TRUE if the property is accessable on the target
     *
     * @param string $property The property-name
     * @param mixed $target The target
     * @return boolean TRUE if the property is accessable, otherwise FALSE
     */
    public function hasProperty($property, $target)
    {
        return parent::hasProperty($property, $target);
    }

    /**
     * Returns the getter methodname for propertyName, or NULL if there ain't one
     *
     * @param object $object The object
     * @param string $property The name of the property to find a getter for
     * @return null|string The method name of the getter
     */
    public function findGetter($object, $property)
    {
        return parent::findGetter($object, $property);
    }

    /**
     * Returns the setter methodname for propertyName, or NULL if there ain't one
     *
     * @param object $object The object
     * @param string $property The name of the property to find a getter for
     * @return null|string The method name of the setter
     */
    public function findSetter($object, $property)
    {
        return parent::findSetter($object, $property);
    }

    /**
     * Splits a property-path into an array
     *
     * @param string $propertyPath The property-path
     * @return array of path part strings
     */
    public function parsePropertyPath($propertyPath)
    {
        return parent::parsePropertyPath($propertyPath);
    }
}
