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
class Reader extends AbstractPropertyAccess implements ReaderInterface
{
    /**
     * (non-PHPdoc)
     * @see ReaderInterface::read()
     */
    public function read(array $path, $target)
    {
        foreach ($path as $property) {
            $value = null;

            if (is_array($target)) {
                $value = $this->getPropertyFromArray($property, $target);
            } elseif (is_object($target)) {
                $value = $this->getPropertyFromObject($property, $target);
            }

            if ($value===null) {
                break;
            }

            $target = $value;
        }

        return isset($value) ? $value : null;
    }
}
