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
namespace Phramz\Commons\Test\Property;

use Phramz\Commons\Property\Reader;
use Phramz\Commons\Property\Writer;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\Property\Writer<extended>
 */
class WriterTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $writer = new Writer();

        $this->assertInstanceOf('Phramz\Commons\Property\WriterInterface', $writer);
    }

    /**
     * @dataProvider writeDataProvider
     */
    public function testWrite($propertyPath, $value, $test)
    {
        $writer = new Writer();
        $reader = new Reader();

        $test = $writer->write($propertyPath, $value, $test);
        $this->assertEquals($value, $reader->read($propertyPath, $test));
    }

    public function writeDataProvider()
    {
        return array(
            array(array('bar', 'foo', 'foo', 'bar'), 'bar.foo.foo.bar!!!', $this->getFixtureMixed()),
            array(array('bar', 'bazz', '4', 'bar'), 'bar.bazz.4.bar!!!', $this->getFixtureMixed()),
            array(array('foo', 'foo', 'foo', 'bar'), 'foo.foo.foo.bar!!!', $this->getFixtureMixed()),
            array(array('foo', 'bazz', '4', 'bar'), 'foo.bazz.4.bar!!!', $this->getFixtureMixed()),
            array(array(), null, $this->getFixtureMixed()),
            array(array('foo', 'bar'), 'foo.bar!!!', array('foo' => array('bar' => 'bazz'))),
            array(array(), null, array('foo' => array('bar' => 'bazz')))
        );
    }
}
