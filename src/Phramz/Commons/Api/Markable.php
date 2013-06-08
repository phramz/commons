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

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
interface Markable extends InputStream
{
    /**
     * Marks the current position
     */
    public function mark($readlimit = 0);

    /**
     * Resets the pointer to the last mark
     */
    public function reset();

    /**
     * Returns the absolute offset from the start of this stream
     *
     * @return integer the offset
     */
    public function offset();
}
