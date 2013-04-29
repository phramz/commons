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
namespace Phramz\Commons\Test\Stream;

use Phramz\Commons\Stream\StringInputStream;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\Stream\StringInputStream<extended>
 */
class StringInputStreamTest extends AbstractTestCase
{
    public function testReadable()
    {
        $stream = new StringInputStream("");
        $this->assertEquals(0, $stream->readable());

        $stream = new StringInputStream("foobar!");
        $this->assertEquals(7, $stream->readable());

        $stream->read();
        $this->assertEquals(6, $stream->readable());

        $stream->read(2);
        $this->assertEquals(4, $stream->readable());

        $stream->read(4);
        $this->assertEquals(0, $stream->readable());
    }

    public function testClose()
    {
        $stream = new StringInputStream("foobar!");

        $this->assertEquals(0, $stream->offset());
        $stream->read();
        $this->assertEquals(1, $stream->offset());

        $stream->close();
        $this->assertEquals(0, $stream->offset());
        $this->assertEquals(0, $stream->readable());
    }

    public function testReset()
    {
        $stream = new StringInputStream("foobar!");

        $this->assertEquals(7, $stream->readable());
        $this->assertEquals(0, $stream->offset());
        $stream->read();

        $this->assertEquals(1, $stream->offset());
        $stream->reset();

        $this->assertEquals(0, $stream->offset());
        $this->assertEquals(7, $stream->readable());
    }

    public function testRead()
    {
        $stream = new StringInputStream("foobar!");

        $this->assertEquals(7, $stream->readable());
        $this->assertEquals(0, $stream->offset());

        $this->assertEquals('f', $stream->read());
        $this->assertEquals(1, $stream->offset());

        $this->assertEquals('oo', $stream->read(2));
        $this->assertEquals(3, $stream->offset());

        $this->assertEquals('bar!', $stream->read(4));
        $this->assertEquals(7, $stream->offset());
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testReadOutOfBoundsException()
    {
        $stream = new StringInputStream("foobar!");

        $stream->read(7);
        $stream->read();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testReadInvalidArgumentException()
    {
        $stream = new StringInputStream("foobar!");

        $stream->read(7);
        $stream->read(-1);
    }

    public function testSkip()
    {
        $stream = new StringInputStream("foobar!");
        $this->assertEquals(0, $stream->offset());

        $stream->skip(3);
        $this->assertEquals(3, $stream->offset());

        $this->assertEquals('bar', $stream->read(3));
        $this->assertEquals(6, $stream->offset());

        $stream->skip(2);
        $this->assertEquals(7, $stream->offset());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSkipInvalidArgumentException()
    {
        $stream = new StringInputStream("foobar!");
        $this->assertEquals(0, $stream->offset());

        $stream->skip(-1);
    }

    public function testMark()
    {
        $stream = new StringInputStream("foobar!");

        $this->assertEquals(0, $stream->offset());
        $this->assertEquals('f', $stream->read());
        $this->assertEquals(1, $stream->offset());

        $stream->reset();

        $this->assertEquals(0, $stream->offset());
        $this->assertEquals('f', $stream->read());
        $this->assertEquals(1, $stream->offset());

        $stream->mark();
        $this->assertEquals('oobar!', $stream->read(6));
        $this->assertEquals(7, $stream->offset());

        $stream->reset();
        $this->assertEquals(1, $stream->offset());
        $this->assertEquals('oobar!', $stream->read(6));
    }

    public function testOffset()
    {
        $stream = new StringInputStream("foobar!");

        $this->assertEquals(0, $stream->offset());
        $this->assertEquals('f', $stream->read());
        $this->assertEquals(1, $stream->offset());
        $this->assertEquals('oo', $stream->read(2));
        $this->assertEquals(3, $stream->offset());

        $stream->reset();
        $this->assertEquals(0, $stream->offset());
    }
}
