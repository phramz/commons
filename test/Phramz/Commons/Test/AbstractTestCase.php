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
namespace Phramz\Commons\Test;

use Phramz\Commons\Test\Fixture\ArrayAccessObject;
use Phramz\Commons\Test\Fixture\PlainObject;
use Phramz\Commons\Test\Fixture\PlainOldObject;
use Phramz\Commons\Test\Fixture\TraversableObject;
use stdClass;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return TraversableObject
     */
    protected function getFixtureTraversable()
    {
        $traversable = new TraversableObject($this->getFixtureIndexedArray());

        return $traversable;
    }

    /**
     * @return array
     */
    protected function getFixtureIndexedArray()
    {
        return array('foo', 'bar', 'bazz', 'foobar', $this->getFixturePopo());
    }

    /**
     * @return array
     */
    protected function getFixtureArray()
    {
        $array = array(
            'foo' => 'bar',
            'f.o.o' => 'b.a.r',
            'bar' => 'bazz',
            'b\.a\r' => 'b.a.z.z',
            ''
        );

        return $array;
    }

    /**
     * @return ArrayAccessObject
     */
    protected function getFixtureArrayAccess()
    {
        return new ArrayAccessObject(array('foo' => 'bar', 'bar' => 'bazz'));
    }

    /**
     * @return stdClass
     */
    protected function getFixtureStdClass()
    {
        $object = new stdClass();
        $object->foo = 'bar';
        $object->bar = 'bazz';

        return $object;
    }

    /**
     * @return PlainOldObject
     */
    protected function getFixturePopo()
    {
        return new PlainOldObject('bar', 'bazz');
    }

    /**
     * @return stdClass
     */
    protected function getFixtureMixed()
    {
        $mixed = new stdClass();
        $mixed->foo = array(
            'foo' => new PlainOldObject(new ArrayAccessObject(array('foo' => 'bar', 'bar' => 'bazz'))),
            'bar' => new ArrayAccessObject(array('foo' => new PlainOldObject('bar', 'bazz'))),
            'bazz' => $this->getFixtureTraversable()
        );
        $mixed->bar = array(
            'foo' => new ArrayAccessObject(array('foo' => new PlainOldObject('bar', 'bazz'))),
            'bar' => new PlainOldObject(new ArrayAccessObject(array('foo' => 'bar', 'bar' => 'bazz'))),
            'bazz' => $this->getFixtureIndexedArray()
        );

        return $mixed;
    }

    /**
     * @return array
     */
    protected function getTestMixed()
    {
        $test = $this->getTestArray();
        $test['c0'] = $this->getTestObject(
            array (
                $this->getTestObject(),
                $this->getTestObject(),
                null,
                'string'
            )
        );
        $test['d0'] = array(
            'd0.0' => 'd0.0',
            'd0.1' => 'd0.1'
        );

        return $test;
    }

    /**
     * @param string $privateValue
     * @param string $publicValue
     * @return PlainObject
     */
    protected function getTestObject($privateValue = 'private', $publicValue = 'public')
    {
        return new PlainObject($privateValue, $publicValue);
    }

    /**
     * @return array
     */
    protected function getTestArray()
    {
        return array (
            'a0' => array(
                'a0_0' => array(
                    'a0_0_0' => '__a0_0_0__'
                ),
                'a0_1' => array(
                    'a0_1_0' => '__a0_1_0__',
                    'a0_1_1' => '__a0_1_1__',
                    'a0_1_3' => array(
                        'a0_1_3_0' => '__a0_1_3_0__'
                    ),
                )
            ),
            'b0' => '__b0__'
        );
    }
}
