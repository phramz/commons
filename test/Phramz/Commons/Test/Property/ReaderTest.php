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
namespace Phramz\Commons\Test\Property;

use Phramz\Commons\Property\Reader;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\Property\Reader<extended>
 */
class ReaderTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $reader = new Reader();

        $this->assertInstanceOf('Phramz\Commons\Property\ReaderInterface', $reader);
    }

    public function testRead()
    {
        $reader = new Reader();

        $test = $this->getFixtureMixed();

        $result = $reader->read(array('bar', 'foo', 'foo', 'bar'), $test);
        $this->assertEquals('bazz', $result);

        $result = $reader->read(array('bar', 'bazz', '4', 'bar'), $test);
        $this->assertEquals('bazz', $result);

        $result = $reader->read(array('bar', 'bazz', '5', 'bar'), $test);
        $this->assertNull($result);
    }
}
