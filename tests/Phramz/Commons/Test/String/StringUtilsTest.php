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
namespace Phramz\Commons\Test\String;

use Phramz\Commons\String\StringUtils;
use Phramz\Commons\Test\AbstractTestCase;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 * @covers Phramz\Commons\String\StringUtils<extended>
 */
class StringUtilsTest extends AbstractTestCase
{
    /**
     * @test
     * @dataProvider rightDataProvider
     */
    public function testRight($string, $len, $assert)
    {
        $stringUtils = new StringUtils();

        $this->assertEquals($assert, $stringUtils->right($string, $len));
    }

    public function rightDataProvider()
    {
        return array(
            array(null, null, ''),
            array(null, 'xxx', ''),
            array('foo', null, ''),
            array('foo', '', ''),
            array('foo', 1, 'o'),
            array('foo', 2, 'oo'),
            array('foo', 3, 'foo'),
            array('foo', 4, 'foo'),
            array('foo', -1, '')
        );
    }

    /**
     * @test
     * @dataProvider leftDataProvider
     */
    public function testLeft($string, $len, $assert)
    {
        $stringUtils = new StringUtils();

        $this->assertEquals($assert, $stringUtils->left($string, $len));
    }

    public function leftDataProvider()
    {
        return array(
            array(null, null, ''),
            array(null, 'xxx', ''),
            array('foo', null, ''),
            array('foo', '', ''),
            array('foo', 1, 'f'),
            array('foo', 2, 'fo'),
            array('foo', 3, 'foo'),
            array('foo', 4, 'foo'),
            array('foo', -1, '')
        );
    }

    /**
     * @test
     * @dataProvider startsWithDataProvider
     */
    public function testStartsWith($haystack, $needle, $assert)
    {
        $stringUtils = new StringUtils();

        if ($assert) {
            $this->assertTrue($stringUtils->startsWith($haystack, $needle));
        } else {
            $this->assertFalse($stringUtils->startsWith($haystack, $needle));
        }
    }

    public function startsWithDataProvider()
    {
        return array(
            array(null, null, false),
            array(null, 'xxx', false),
            array('foo', null, false),
            array('foo', '', false),
            array('foo', 'f', true),
            array('foo', 'foo', true),
            array('foo', 'foo ', false),
            array('foo ', 'o', false),
            array('foo ', 'o ', false),
            array('foo', 'fo', true),
            array('foo', ' foo', false),
            array('foo', 'fooo', false),
            array('foo', 'bar', false),
        );
    }

    /**
     * @test
     * @dataProvider endsWithDataProvider
     */
    public function testEndsWith($haystack, $needle, $assert)
    {
        $stringUtils = new StringUtils();

        if ($assert) {
            $this->assertTrue($stringUtils->endsWith($haystack, $needle));
        } else {
            $this->assertFalse($stringUtils->endsWith($haystack, $needle));
        }
    }

    public function endsWithDataProvider()
    {
        return array(
            array(null, null, false),
            array(null, 'xxx', false),
            array('foo', null, false),
            array('foo', '', false),
            array('foo', 'f', false),
            array('foo', 'foo', true),
            array('foo', 'o ', false),
            array('foo ', 'o', false),
            array('foo ', 'o ', true),
            array('foo', 'o', true),
            array('foo', 'oo', true),
            array('foo', 'fooo', false),
            array('foo', 'bar', false),
        );
    }

    /**
     * @test
     * @dataProvider containsWordDataProvider
     */
    public function testContainsWord($haystack, $needle, $assert)
    {
        $stringUtils = new StringUtils();

        if ($assert) {
            $this->assertTrue($stringUtils->containsWord($haystack, $needle));
        } else {
            $this->assertFalse($stringUtils->containsWord($haystack, $needle));
        }
    }

    public function containsWordDataProvider()
    {
        return array(
            array(null, null, false),
            array(null, 'xxx', false),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', null, false),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '', false),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', ' ', true),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'f', false),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '.', false),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'amet', true),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'sectetur', false),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'consectetur', true),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Lorem', true),
            array('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'elit', true),
        );
    }

    /**
     * @test
     * @dataProvider containsDataProvider
     */
    public function testContains($haystack, $needle, $assert)
    {
        $stringUtils = new StringUtils();

        if ($assert) {
            $this->assertTrue($stringUtils->contains($haystack, $needle));
        } else {
            $this->assertFalse($stringUtils->contains($haystack, $needle));
        }
    }

    public function containsDataProvider()
    {
        return array(
            array(null, null, false),
            array(null, 'xxx', false),
            array('foo', null, false),
            array('foo', '', false),
            array('foo', 'f', true),
            array('foo', 'foo', true),
            array('foo', 'fooo', false),
            array('foo', 'oo', true),
            array('foo', 'fo', true),
            array('foo', 'bar', false),
        );
    }

    /**
     * @test
     * @dataProvider containsPrefixDataProvider
     */
    public function testContainsPrefix($haystack, $needle, $assert)
    {
        $stringUtils = new StringUtils();

        if ($assert) {
            $this->assertTrue($stringUtils->containsPrefix($haystack, $needle));
        } else {
            $this->assertFalse($stringUtils->containsPrefix($haystack, $needle));
        }
    }

    public function containsPrefixDataProvider()
    {
        return array(
            array(null, null, false),
            array(null, 'xxx', false),
            array('foo', null, false),
            array('foo', '', false),
            array('foo', 'f', false),
            array('foo', 'foo', true),
            array('foo', 'fooo', false),
            array('foo-', 'foo', true),
            array('foo-', 'foo-', true)
        );
    }
}
