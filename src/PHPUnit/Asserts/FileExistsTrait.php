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

use GeckoPackages\PHPUnit\Constraints\FileExistsConstraint;

/**
 * Replaces the PHPUnit `assertFileExists` method. This assert does not pass if there is a directory rather than a file.
 *
 * Replacement for PHPUnits `assertFileExists` and `assertFileNotExists`.
 * Asserts when the filename exists and is a regular file, i.e. directories do not pass.
 * (Note. Since this changes the default behaviour of the PHPUnit assert this has been placed in a separate trait)
 *
 * @requires PHPUnit >= 3.0.0 (https://phpunit.de/)
 *
 * @api
 *
 * @author SpacePossum
 */
trait FileExistsTrait
{
    /**
     * Assert the filename exists and is a regular file.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertFileExists($filename, $message = '')
    {
        self::assertFileExisting($filename, $message, 'assertFileExists', new FileExistsConstraint());
    }

    /**
     * Assert the filename does not exists or is not a regular file.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertFileNotExists($filename, $message = '')
    {
        self::assertFileExisting($filename, $message, 'assertFileNotExists', new \PHPUnit_Framework_Constraint_Not(new FileExistsConstraint()));
    }

    private static function assertFileExisting($filename, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, ['assertThat']);

        if (!is_string($filename)) {
            throw AssertHelper::createArgumentException(__TRAIT__, $method, 'string', $filename);
        }

        self::assertThat($filename, $constraint, $message);
    }
}
