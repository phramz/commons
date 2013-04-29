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

use ArrayAccess;
use ReflectionClass;
use Traversable;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
abstract class AbstractPropertyAccess
{
    /**
     * Retrieves a property-value from an object. What ever succeeds first by getter,
     * direct access or ArrayAccess will be returned ... otherwise NULL.
     *
     * @param string $property The property-name
     * @param object $target object to retrieve the value from
     * @return mixed The value or NULL if the property not accessable
     */
    protected function getPropertyFromObject($property, $target)
    {
        if (!is_object($target)) {
            return null;
        }

        $getter = $this->findGetter($target, $property);
        if ($getter) {
            return $target->$getter();
        }

        if (isset($target->$property)) {
            return $target->$property;
        }

        if ($target instanceof ArrayAccess) {
            return $this->getPropertyFromArray($property, $target);
        }

        if ($target instanceof Traversable) {
            return $this->getPropertyFromTraversable($property, $target);
        }

        return null;
    }

    /**
     * Retrieves a property-value from an array or Traversable-object
     *
     * @param string $property The property-name
     * @param mixed $target array or ArrayAccess to retrieve the value from
     * @return mixed The value or NULL if the property not accessable
     */
    protected function getPropertyFromTraversable($property, $target)
    {
        if ($target instanceof Traversable) {
            foreach ($target as $key => $value) {
                if ($key == $property) {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * Retrieves a property-value from an array of ArrayAccess-object
     *
     * @param string $property The property-name
     * @param mixed $target array or ArrayAccess to retrieve the value from
     * @return mixed The value or NULL if the property not accessable
     */
    protected function getPropertyFromArray($property, $target)
    {
        if ($target instanceof ArrayAccess) {
            return $target->offsetExists($property) ? $target->offsetGet($property) : null;
        }

        if (is_array($target)) {
            return array_key_exists($property, $target) ? $target[$property] : null;
        }

        return null;
    }

    /**
     * Checks if direct property access is available or not
     *
     * @param string $property The propertyname
     * @param mixed $target The target
     * @return bool TRUE if the property is accessable via direct access
     */
    protected function isAccessable($property, $target)
    {
        // array access offset exists?
        if ($target instanceof ArrayAccess && $target->offsetExists($property)) {
            return true;
        }

        // array key exists?
        if (is_array($target)) {
            return array_key_exists($property, $target);
        }

        // public property exists?
        if (is_object($target)) {
            if ($target instanceof \stdClass && isset($target->$property)) {
                return true;
            }

            $reflection = new ReflectionClass($target);
            if ($reflection->hasProperty($property)) {
                $property = $reflection->getProperty($property);
                return $property->isPublic();
            }
        }

        return false;
    }

    /**
     * Returns TRUE if the property is accessable on the target
     *
     * @param string $property The property-name
     * @param mixed $target The target
     * @return boolean TRUE if the property is accessable, otherwise FALSE
     */
    protected function hasProperty($property, $target)
    {
        return $this->isAccessable($property, $target) || $this->findGetter($target, $property);
    }

    /**
     * Returns the getter methodname for propertyName, or NULL if there ain't one
     *
     * @param object $object The object
     * @param string $property The name of the property to find a getter for
     * @return null|string The method name of the getter
     */
    protected function findGetter($object, $property)
    {
        if (!is_object($object)) {
            return null;
        }

        $method = 'get' . ucfirst($property);
        if (is_callable(array($object, $method))) {
            return $method;
        }

        $method = 'is' . ucfirst($property);
        if (is_callable(array($object, $method))) {
            return $method;
        }

        $method = 'has' . ucfirst($property);
        if (is_callable(array($object, $method))) {
            return $method;
        }

        return null;
    }

    /**
     * Returns the setter methodname for propertyName, or NULL if there ain't one
     *
     * @param object $object The object
     * @param string $property The name of the property to find a getter for
     * @return null|string The method name of the setter
     */
    protected function findSetter($object, $property)
    {
        $method = 'set' . ucfirst($property);
        if (is_object($object) && is_callable(array($object, $method))) {
            return $method;
        }

        return null;
    }

    /**
     * Splits a property-path into an array
     *
     * @param string $propertyPath The property-path
     * @return array of path part strings
     */
    protected function parsePropertyPath($propertyPath)
    {
        if (!is_scalar($propertyPath)) {
            return array();
        }

        $propertyPath = (string) $propertyPath;
        $splitCharacter = '.';
        $escapeCharacter = '\\';

        $result = array();
        $parsed = "";
        $literal = false;
        for ($i=0; $i<strlen($propertyPath); $i++) {
            // unescape chars
            if (!$literal && $propertyPath{$i} == $splitCharacter) {
                $result[] = $parsed;
                $parsed = "";

                continue;
            }

            if (!$literal && $propertyPath{$i} == $escapeCharacter) {
                $literal = true;

                continue;
            }

            $parsed .= $propertyPath{$i};
            $literal = false;
        }

        $result[] = $parsed;

        return $result;
    }
}
