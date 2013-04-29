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
namespace Phramz\Commons\Test;

use Phramz\Commons\Property\PropertyUtils;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\Property\PropertyUtils<extended>
 */
class PropertyUtilsTest extends AbstractTestCase
{
    /**
     * @test
     * @dataProvider findSetterDataProvider
     */
    public function testFindSetter($property, $getter, $test)
    {
        $propertyUtils = new PropertyUtils();

        $this->assertEquals($getter, $propertyUtils->findSetter($test, $property));
    }

    public function findSetterDataProvider()
    {
        return array(
            array('foo', null, $this->getFixtureStdClass()),
            array('bar', null, $this->getFixtureStdClass()),
            array('', null, $this->getFixtureStdClass()),
            array(null, null, $this->getFixtureStdClass()),
            array('foo', null, $this->getFixtureArray()),
            array('bar', null, $this->getFixtureArray()),
            array('', null, $this->getFixtureArray()),
            array(null, null, $this->getFixtureArray()),
            array('foo', null, $this->getFixtureArrayAccess()),
            array('bar', null, $this->getFixtureArrayAccess()),
            array('', null, $this->getFixtureArrayAccess()),
            array(null, null, $this->getFixtureArrayAccess()),
            array('foo', 'setFoo', $this->getFixturePopo()),
            array('bar', 'setBar', $this->getFixturePopo()),
            array('foobar', 'setFoobar', $this->getFixturePopo()),
            array('bazz', 'setBazz', $this->getFixturePopo()),
            array('', null, $this->getFixturePopo()),
            array(null, null, $this->getFixturePopo())
        );
    }

    /**
     * @test
     * @dataProvider findGetterDataProvider
     */
    public function testFindGetter($property, $getter, $test)
    {
        $propertyUtils = new PropertyUtils();

        $this->assertEquals($getter, $propertyUtils->findGetter($test, $property));
    }

    public function findGetterDataProvider()
    {
        return array(
            array('foo', null, $this->getFixtureStdClass()),
            array('bar', null, $this->getFixtureStdClass()),
            array('', null, $this->getFixtureStdClass()),
            array(null, null, $this->getFixtureStdClass()),
            array('foo', null, $this->getFixtureArray()),
            array('bar', null, $this->getFixtureArray()),
            array('', null, $this->getFixtureArray()),
            array(null, null, $this->getFixtureArray()),
            array('foo', null, $this->getFixtureArrayAccess()),
            array('bar', null, $this->getFixtureArrayAccess()),
            array('', null, $this->getFixtureArrayAccess()),
            array(null, null, $this->getFixtureArrayAccess()),
            array('foo', 'getFoo', $this->getFixturePopo()),
            array('bar', 'getBar', $this->getFixturePopo()),
            array('foobar', 'hasFoobar', $this->getFixturePopo()),
            array('bazz', 'isBazz', $this->getFixturePopo()),
            array('', null, $this->getFixturePopo()),
            array(null, null, $this->getFixturePopo())
        );
    }

    /**
     * @test
     * @dataProvider hasPropertyDataProvider
     */
    public function testHasProperty(array $assertTrue, array $assertFalse, $test)
    {
        $propertyUtils = new PropertyUtils();

        foreach ($assertTrue as $property) {
            $this->assertTrue($propertyUtils->hasProperty($property, $test));
        }

        foreach ($assertFalse as $property) {
            $this->assertFalse($propertyUtils->hasProperty($property, $test));
        }
    }

    public function hasPropertyDataProvider()
    {
        return array(
            array(array('foo', 'bar'), array('foobar', '', null), $this->getFixtureStdClass()),
            array(array('foo', 'bar'), array('foobar', '', null), $this->getFixtureArray()),
            array(array('foo', 'bar'), array('foobar', '', null), $this->getFixtureArrayAccess()),
            array(array('foo', 'bar', 'foobar'), array('foobar!', '', null), $this->getFixturePopo()),
            array(array(0, 1, 2, 3, 4), array(-1, 5, 6, null, '', 'foo', 'bar'), $this->getFixtureIndexedArray())
        );
    }

    /**
     * @test
     * @dataProvider setPropertyDataProvider
     */
    public function testSetProperty($property, $value, $expected, $test)
    {
        $propertyUtils = new PropertyUtils();

        $actual = $propertyUtils->setProperty($property, $value, $test);

        $this->assertEquals($expected, $actual);
        $this->assertEquals($value, $propertyUtils->getProperty($property, $actual));
    }

    public function setPropertyDataProvider()
    {
        $array = $this->getFixtureArray();
        $arrayAccess = $this->getFixtureArrayAccess();
        $object = $this->getFixtureStdClass();
        $plainOldObject = $this->getFixturePopo();
        $mixed = $this->getFixtureMixed();
        $indexedArray = $this->getFixtureIndexedArray();

        return array(
            // simple array
            array('foo', 'bar', $array, $array),
            array(
                'foo.bar', 'foobar!',
                array('foo' => array('bar' => 'foobar!')),
                array('foo' => array('bar' => 'bazz'))
            ),
            // simple object
            array('foo', 'foobar!', $object, $object),
            // simple ArrayAccess
            array('foo', 'foobar!', $arrayAccess, $arrayAccess),
            // simple Popo
            array ('foo', 'bar', $plainOldObject, $plainOldObject),
            // indexed array
            array('0', 'foobar!', array('foobar!', 'bar', 'bazz', 'foobar', $this->getFixturePopo()), $indexedArray),
            array(0, 'foobaaar!', array('foobaaar!', 'bar', 'bazz', 'foobar', $this->getFixturePopo()), $indexedArray),
            array('1', 'barfoo', array('foo', 'barfoo', 'bazz', 'foobar', $this->getFixturePopo()), $indexedArray),
            array('2', 'bazzer', array('foo', 'bar', 'bazzer', 'foobar', $this->getFixturePopo()), $indexedArray),
            array('3', 'foooo', array('foo', 'bar', 'bazz', 'foooo', $this->getFixturePopo()), $indexedArray),
            // mixed
            array ('foo.foo.foo.foo', 'foobar!', $mixed, $mixed),
            array ('bar.bar.foo.bar', 'bazz', $mixed, $mixed),
            array('foo.bazz.4.foo', 'foobar!', $mixed, $mixed),
            array('foo.bazz.4.bar', 'foobar!', $mixed, $mixed),
        );
    }

    /**
     * @test
     * @dataProvider getPropertyDataProvider
     */
    public function testGetProperty($property, $expected, $test)
    {
        $propertyUtils = new PropertyUtils();
        $actual = $propertyUtils->getProperty($property, $test);

        $this->assertEquals($expected, $actual);
    }

    public function getPropertyDataProvider()
    {
        $array = $this->getFixtureArray();
        $arrayAccess = $this->getFixtureArrayAccess();
        $object = $this->getFixtureStdClass();
        $plainOldObject = $this->getFixturePopo();
        $indexedArray = $this->getFixtureIndexedArray();
        $traversable = $this->getFixtureTraversable();
        $mixed = $this->getFixtureMixed();

        return array(
            // simple array
            array('foo', 'bar', $array),
            array('f\.o\.o', 'b.a.r', $array),
            array('b\\\\\.a\\\\r', 'b.a.z.z', $array),
            array('.foo', null, $array),
            array('foo.', null, $array),
            array('bazz', null, $array),
            array('foo.bar', null, $array),
            // simple object
            array('foo', 'bar', $object),
            array('bazz', null, $object),
            array('foo.bar', null, $object),
            // simple ArrayAccess
            array('foo', 'bar', $arrayAccess),
            array('bazz', null, $arrayAccess),
            array('foo.bar', null, $arrayAccess),
            // simple Popo
            array('foo', 'bar', $plainOldObject),
            array('bazz', null, $plainOldObject),
            array('foo.bar', null, $plainOldObject),
            // indexed array
            array('0', 'foo', $indexedArray),
            array(0, 'foo', $indexedArray),
            array('1', 'bar', $indexedArray),
            array('2', 'bazz', $indexedArray),
            array('3', 'foobar', $indexedArray),
            array('5', null, $indexedArray),
            array(5, null, $indexedArray),
            array('1.0', null, $indexedArray),
            array('1.foo', null, $indexedArray),
            // traversable object
            array('0', 'foo', $traversable),
            array(0, 'foo', $traversable),
            array('1', 'bar', $traversable),
            array('2', 'bazz', $traversable),
            array('3', 'foobar', $traversable),
            array('5', null, $traversable),
            array(5, null, $traversable),
            array('1.0', null, $traversable),
            array('1.foo', null, $traversable),
            // mixed
            array('foo.foo.foo.foo', 'bar', $mixed),
            array('foo.foo..foo.foo', null, $mixed),
            array('bar.bar.foo.bar', 'bazz', $mixed),
            array('.bar.bar.foo.bar', null, $mixed),
            array('..bar.bar.foo.bar', null, $mixed),
            array('bar.bar.foo.bar.', null, $mixed),
            array('bar.bar.foo.bar..', null, $mixed),
            array('bar.bar.bar.bar', null, $mixed),
            array('foo.bazz.3', 'foobar', $mixed),
            array('foo.bazz.4.foo', 'bar', $mixed),
            array('foo.bazz.4.bar', 'bazz', $mixed),
            array('foo.bazz.4.bazz', null, $mixed),
            array('foo.bazz.4.foo.bar', null, $mixed),
        );
    }
}
