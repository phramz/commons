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
namespace Phramz\Commons\String;

/**
 * @author Maximilian Reichel <mr@phramz.com>
 */
class StringUtils 
{
    /**
     * Returns n ($length) chars from the end of $string
     *
     * @param string $string the string to extract the substring from
     * @param integer $length how many chars should be extracted (positiv integer)
     * @return string the substring
     */
    public function right($string, $length)
    {
        if (!is_scalar($string) || !is_scalar($length)) {
            return '';
        }

        $string = (string) $string;
        $length = (integer) $length;

        if ($length <= 0) {
            return '';
        }

        return strrev(substr(strrev($string), 0, $length));
    }

    /**
     * Returns n ($length) chars from the beginning of $string
     *
     * @param string $string the string to extract the substring from
     * @param integer $length how many chars should be extracted (positiv integer)
     * @return string the substring
     */
    public function left($string, $length)
    {
        if (!is_scalar($string) || !is_scalar($length)) {
            return '';
        }

        $string = (string) $string;
        $length = (integer) $length;

        if ($length <= 0) {
            return '';
        }

        return substr($string, 0, $length);
    }

    /**
     * Returns TRUE if $haystack equals $needle or if $haystack starts with $needle
     * followed by a hyphen ('-'). Otherwise this method will return FALSE.
     *
     * @param string $haystack The haystack to search
     * @param string $needle The needle to find
     * @return boolean TRUE if $needle matches $haystack
     */
    public function containsPrefix($haystack, $needle)
    {
        return $this->match(
            $haystack,
            $needle,
            function($haystack, $needle)
            {
                return $haystack == $needle || strpos($haystack, $needle . '-') === 0;
            }
        );
    }

    /**
     * Returns TRUE if $haystack contains $needle. Otherwise this method will return FALSE.
     *
     * @param string $haystack The haystack to search
     * @param string $needle The needle to find
     * @return boolean TRUE if $needle matches $haystack
     */
    public function contains($haystack, $needle)
    {
        return $this->match(
            $haystack,
            $needle,
            function($haystack, $needle)
            {
                return strpos($haystack, $needle) !== false;
            }
        );
    }

    /**
     * Returns TRUE if $haystack contains $needle, delimited by word-boundaries.
     * Otherwise this method will return FALSE.
     *
     * @param string $haystack The haystack to search
     * @param string $needle The needle to find
     * @return boolean TRUE if $needle matches $haystack
     */
    public function containsWord($haystack, $needle)
    {
        return $this->match(
            $haystack,
            $needle,
            function($haystack, $needle)
            {
                return preg_match('/\\b' . preg_quote($needle, '/') . '\\b/', $haystack);
            }
        );
    }

    /**
     * Returns TRUE if $haystack starts with $needle. Otherwise this method will return FALSE.
     *
     * @param string $haystack The haystack to search
     * @param string $needle The needle to find
     * @return boolean TRUE if $needle matches $haystack
     */
    public function startsWith($haystack, $needle)
    {
        return $this->match(
            $haystack,
            $needle,
            function($haystack, $needle)
            {
                return preg_match('/^' . preg_quote($needle, '/') . '/', $haystack);
            }
        );
    }

    /**
     * Returns TRUE if $haystack ends with $needle. Otherwise this method will return FALSE.
     *
     * @param string $haystack The haystack to search
     * @param string $needle The needle to find
     * @return boolean TRUE if $needle matches $haystack
     */
    public function endsWith($haystack, $needle)
    {
        return $this->match(
            $haystack,
            $needle,
            function($haystack, $needle)
            {
                return preg_match('/' . preg_quote($needle, '/') . '$/', $haystack);
            }
        );
    }

    /**
     * @param string $haystack The haystack to search
     * @param string $needle The needle to find
     * @param callable $closure The method for matching
     * @return boolean TRUE if $needle matches $haystack
     */
    private function match($haystack, $needle, \Closure $closure)
    {
        if (!is_scalar($haystack) || !is_scalar($needle)) {
            return false;
        }

        $haystack = (string) $haystack;
        $needle = (string) $needle;

        if (empty($haystack) || empty($needle)) {
            return false;
        }

        return (boolean) $closure($haystack, $needle);
    }
}
