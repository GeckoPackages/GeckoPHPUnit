<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GeckoPackages\PHPUnit\Asserts;

use GeckoPackages\PHPUnit\Constraints\SameStringsConstraint;

/**
 * Provides asserts for testing of strings.
 *
 * @requires PHPUnit >= 3.0.0 (https://phpunit.de/)
 *
 * @api
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 * @author SpacePossum
 */
trait StringsAssertTrait
{
    /**
     * Assert that strings are not identical.
     *
     * @param string $expected
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotSameStrings($expected, $actual, $message = '')
    {
        self::assertStringsIdentity($actual, $message, __FUNCTION__, new \PHPUnit_Framework_Constraint_Not(new SameStringsConstraint($expected)));
    }

    /**
     * Assert that strings are identical.
     *
     * @param string $expected
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertSameStrings($expected, $actual, $message = '')
    {
        self::assertStringsIdentity($actual, $message, __FUNCTION__, new SameStringsConstraint($expected));
    }

    /**
     * Assert value is a string and is empty.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertStringIsEmpty($actual, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertStringIsEmpty', array('assertThat', 'assertEmpty'));
        self::assertThat($actual, new \PHPUnit_Framework_Constraint_IsType('string'), $message);
        self::assertEmpty($actual, $message);
    }

    /**
     * Assert value is a string and is not empty.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertStringIsNotEmpty($actual, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertStringIsNotEmpty', array('assertThat', 'assertNotEmpty'));
        self::assertThat($actual, new \PHPUnit_Framework_Constraint_IsType('string'), $message);
        self::assertNotEmpty($actual, $message);
    }

    /**
     * Assert value is a string and not only contains white space characters (" \t\n\r\0\x0B").
     *
     * Uses PHP function trim @see http://php.net/manual/en/function.trim.php
     * The following characters are considered white space:
     * - " "    (ASCII 32 (0x20)), an ordinary space.
     * - "\t"   (ASCII  9 (0x09)), a tab.
     * - "\n"   (ASCII 10 (0x0A)), a new line (line feed).
     * - "\r"   (ASCII 13 (0x0D)), a carriage return.
     * - "\0"   (ASCII  0 (0x00)), the NUL-byte.
     * - "\x0B" (ASCII 11 (0x0B)), a vertical tab.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertStringIsNotWhiteSpace($actual, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertStringIsNotWhiteSpace', array('assertThat', 'assertNotEmpty'));
        self::assertThat($actual, new \PHPUnit_Framework_Constraint_IsType('string'), $message);
        self::assertNotEmpty(trim($actual), $message);
    }

    /**
     * Assert value is a string and only contains white space characters (" \t\n\r\0\x0B").
     *
     * Uses PHP function trim @see http://php.net/manual/en/function.trim.php
     * The following characters are considered white space:
     * - " "    (ASCII 32 (0x20)), an ordinary space.
     * - "\t"   (ASCII  9 (0x09)), a tab.
     * - "\n"   (ASCII 10 (0x0A)), a new line (line feed).
     * - "\r"   (ASCII 13 (0x0D)), a carriage return.
     * - "\0"   (ASCII  0 (0x00)), the NUL-byte.
     * - "\x0B" (ASCII 11 (0x0B)), a vertical tab.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertStringIsWhiteSpace($actual, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertStringIsWhiteSpace', array('assertThat', 'assertEmpty'));
        self::assertThat($actual, new \PHPUnit_Framework_Constraint_IsType('string'), $message);
        self::assertEmpty(trim($actual), $message);
    }

    /**
     * @param mixed                         $actual
     * @param string                        $message
     * @param string                        $method
     * @param \PHPUnit_Framework_Constraint $constraint
     */
    private static function assertStringsIdentity($actual, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, array('assertThat'));
        self::assertThat($actual, $constraint, $message);
    }
}
