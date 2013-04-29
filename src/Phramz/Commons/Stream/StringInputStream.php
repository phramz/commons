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
namespace Phramz\Commons\Stream;

use InvalidArgumentException;
use OutOfBoundsException;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
class StringInputStream implements MarkableInputStreamInterface
{
    private $string = null;
    private $offset = 0;
    private $mark = 0;

    /**
     * Constructor
     *
     * @param string $string The input data
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * (non-PHPdoc)
     * @see InputStreamInterface::close()
     */
    public function close()
    {
        $this->string = null;
        $this->offset = 0;
        $this->mark = 0;
    }

    /**
     * (non-PHPdoc)
     * @see InputStreamInterface::read()
     */
    public function read($bytes = 1)
    {
        $bytes = intval($bytes);

        if ($bytes < 0) {
            throw new InvalidArgumentException("bytes must be a positiv integer!");
        }

        if ($bytes > $this->readable()) {
            throw new OutOfBoundsException("reached end of stream!");
        }

        $value = substr($this->string, $this->offset, $bytes);
        $this->offset += strlen($value);

        return $value;
    }

    /**
     * (non-PHPdoc)
     * @see MarkableInterface::reset()
     */
    public function reset()
    {
        $this->offset = $this->mark;
    }

    /**
     * (non-PHPdoc)
     * @see InputStreamInterface::skip()
     */
    public function skip($bytes = 1)
    {
        $bytes = intval($bytes);

        if ($bytes < 0) {
            throw new InvalidArgumentException("bytes must be a positiv integer!");
        }

        $readable = $this->readable();
        if ($readable < $bytes) {
            $this->offset += $readable;

            return $readable;
        }

        $this->offset += $bytes;

        return $bytes;
    }

    /**
     * (non-PHPdoc)
     * @see InputStreamInterface::readable()
     */
    public function readable()
    {
        return strlen($this->string) - $this->offset;
    }

    /**
     * (non-PHPdoc)
     * @see MarkableInterface::mark()
     */
    public function mark($readlimit = 0)
    {
        $this->mark = $this->offset;
    }

    /**
     * (non-PHPdoc)
     * @see MarkableInterface::mark()
     */
    public function offset()
    {
        return $this->offset;
    }
}
