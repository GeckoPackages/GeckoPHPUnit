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
 * Provides asserts for testing of identical strings with line ending difference reporter.
 *
 * @requires PHPUnit >= 3.0.0 (https://phpunit.de/)
 *
 * @api
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
trait SameStringsTrait
{
    /**
     * Assert that strings are identical.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    public static function assertSameStrings($expected, $actual, $message = '')
    {
        self::assertStringsIdentity($actual, $message, __FUNCTION__, new SameStringsConstraint($expected));
    }

    /**
     * Assert that strings are not identical.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    public static function assertNotSameStrings($expected, $actual, $message = '')
    {
        self::assertStringsIdentity($actual, $message, __FUNCTION__, new \PHPUnit_Framework_Constraint_Not(new SameStringsConstraint($expected)));
    }

    private static function assertStringsIdentity($actual, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, ['assertThat']);
        self::assertThat($actual, $constraint, $message);
    }
}
