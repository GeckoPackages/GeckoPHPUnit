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
     * Assert value is not a scalar.
     *
     * @param mixed  $actual
     * @param string $message
     */
    public static function assertNotScalar($actual, $message = '')
    {
        self::assertTypeOfScalar($actual, $message, 'assertNotScalar', new \PHPUnit_Framework_Constraint_Not(new ScalarConstraint(ScalarConstraint::TYPE_SCALAR)));
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
     * @param mixed                         $actual
     * @param string                        $message
     * @param string                        $method
     * @param \PHPUnit_Framework_Constraint $constraint
     */
    private static function assertTypeOfScalar($actual, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, array('assertThat'));
        self::assertThat($actual, $constraint, $message);
    }
}
