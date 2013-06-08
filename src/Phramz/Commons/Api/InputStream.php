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
interface InputStream
{
    /**
     * Returns the number of bytes that can be read or skipped over.
     *
     * @return integer number of bytes
     */
    public function readable();

    /**
     * Closes this input stream.
     */
    public function close();

    /**
     * Resets this input stream.
     */
    public function reset();

    /**
     * Reads the next n bytes from offset
     *
     * @param integer $bytes maximum number of bytes to read
     * @return string the data read from this input stream
     */
    public function read($bytes = 1);

    /**
     * Discards n bytes of data.
     *
     * @param integer $bytes Number of bytes to skip
     * @return integer number of skipped bytes
     */
    public function skip($bytes = 1);
}
