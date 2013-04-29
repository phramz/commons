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
namespace Phramz\Commons\Test\Fixture;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
class PlainOldObject
{
    private $foo;
    private $bar;
    private $bazz;
    private $foobar;

    public function __construct($foo = null, $bar = null)
    {
        $this->bar = $bar;
        $this->foo = $foo;
    }

    public function setBar($bar)
    {
        $this->bar = $bar;
    }

    public function getBar()
    {
        return $this->bar;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function setBazz($bazz)
    {
        $this->bazz = $bazz;
    }

    public function isBazz()
    {
        return $this->bazz;
    }

    public function setFoobar($foobar)
    {
        $this->foobar = $foobar;
    }

    public function hasFoobar()
    {
        return $this->foobar;
    }


}
