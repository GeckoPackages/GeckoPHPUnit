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

use GeckoPackages\PHPUnit\Constraints\ScalarConstraint;

/**
 * Provides asserts for testing of scalars such as integer, float, etc.
 *
 * Additional shorthand PHPUnit asserts to test (for) scalar types.
 *
 * @requires PHPUnit >= 3.5.0 (https://phpunit.de/)
 *
 * @api
 *
 * @author SpacePossum
 */
trait ScalarAssertTrait
{
    /**
     * Assert value is an array.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertArray($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertArray', new ScalarConstraint(ScalarConstraint::TYPE_ARRAY));
    }

    /**
     * Assert value is a bool (boolean).
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertBool($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertBool', new ScalarConstraint(ScalarConstraint::TYPE_BOOL));
    }

    /**
     * Assert value is a float (double, real).
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertFloat($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertFloat', new ScalarConstraint(ScalarConstraint::TYPE_FLOAT));
    }

    /**
     * Assert value is an int (integer).
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertInt($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertInt', new ScalarConstraint(ScalarConstraint::TYPE_INT));
    }

    /**
     * Assert value is a string.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertString($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertString', new ScalarConstraint(ScalarConstraint::TYPE_STRING));
    }

    /**
     * Assert value is a string and is empty.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertStringIsEmpty($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertString', new ScalarConstraint(ScalarConstraint::TYPE_STRING));
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
        self::assertTypeOfScalar($actual, $message, 'assertString', new ScalarConstraint(ScalarConstraint::TYPE_STRING));
        self::assertNotEmpty($actual, $message);
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
        self::assertTypeOfScalar($actual, $message, 'assertString', new ScalarConstraint(ScalarConstraint::TYPE_STRING));
        self::assertEmpty(trim($actual), $message);
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
        self::assertTypeOfScalar($actual, $message, 'assertString', new ScalarConstraint(ScalarConstraint::TYPE_STRING));
        self::assertNotEmpty(trim($actual), $message);
    }

    /**
     * Assert value is a scalar.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertScalar($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertScalar', new ScalarConstraint(ScalarConstraint::TYPE_SCALAR));
    }

    /**
     * Assert value is not an array.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotArray($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotArray', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_ARRAY)));
    }

    /**
     * Assert value is not a bool (boolean).
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotBool($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotBool', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_BOOL)));
    }

    /**
     * Assert value is not a float (double, real).
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotFloat($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotFloat', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_FLOAT)));
    }

    /**
     * Assert value is not an int (integer).
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotInt($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotInt', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_INT)));
    }

    /**
     * Assert value is not a string.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotString($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotString', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_STRING)));
    }

    /**
     * Assert value is not a scalar.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotScalar($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotScalar', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_SCALAR)));
    }

    private static function assertTypeOfScalar($actual, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, array('assertThat'));

        self::assertThat($actual, $constraint, $message);
    }
}
