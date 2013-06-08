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

use Phramz\Commons\Api\Writer;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
class PropertyWriter extends AbstractPropertyAccess implements Writer
{
    /**
     * (non-PHPdoc)
     * @see WriterInterface::write()
     */
    public function write(array $path, $value, $target)
    {
        if (is_array($target)) {
            $target = $this->setPropertyToArray($path, $value, $target);
        } elseif (is_object($target)) {
            $target = $this->setPropertyToObject($path, $value, $target);
        }

        return $target;
    }

    /**
     * Sets a value to an array or ArrayAccess target
     *
     * @param array $path Path the property
     * @param mixed $value value to set
     * @param array|\ArrayAccess $target the target holding the property
     * @return array|\ArrayAccess the processed target
     */
    private function setPropertyToArray(array $path, $value, $target)
    {
        if (!is_array($target) && !$target instanceof \ArrayAccess) {
            return $target;
        }

        $property = array_shift($path);
        if ($property===null) {
            return $target;
        }

        if (count($path)>0) {
            // go deeper
            $nestedTarget = $this->getPropertyFromArray($property, $target);

            if (is_array($nestedTarget)) {
                $target[$property] = $this->setPropertyToArray($path, $value, $nestedTarget);
            } elseif (is_object($nestedTarget)) {
                $target[$property] = $this->setPropertyToObject($path, $value, $nestedTarget);
            } else {
                return $target;
            }
        } else {
            $target[$property] = $value;
        }

        return $target;
    }

    /**
     * Sets a value to a object target
     *
     * @param array $path Path to the property
     * @param mixed $value value to set
     * @param object $target the target holding the property
     * @return object the processed target
     */
    private function setPropertyToObject(array $path, $value, $target)
    {
        if (!is_object($target)) {
            return $target;
        }

        $property = array_shift($path);
        if ($property===null) {
            return $target;
        }

        if (count($path)>0) {
            // go deeper
            $nestedTarget = $this->getPropertyFromObject($property, $target);

            if (is_array($nestedTarget)) {
                $value = $this->setPropertyToArray($path, $value, $nestedTarget);
            } elseif (is_object($nestedTarget)) {
                $value = $this->setPropertyToObject($path, $value, $nestedTarget);
            } else {
                return $target;
            }
        }

        $setter = $this->findSetter($target, $property);

        if ($setter) {
            $target->$setter($value);
        } elseif ($target instanceof \ArrayAccess && $target->offsetExists($property)) {
            $target->offsetSet($property, $value);
        } elseif ($this->isAccessable($property, $target)) {
            $target->$property = $value;
        }

        return $target;
    }
}
