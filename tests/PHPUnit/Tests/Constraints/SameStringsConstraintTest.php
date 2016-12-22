<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\SameStringsConstraint;

/**
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class SameStringsConstraintTest extends AbstractGeckoPHPUnitTest
{
    public function testSameStringsConstraintFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('@^Failed asserting that two strings are identical\.\n #Warning: Strings contain different line endings! Debug using remapping \["\\\r" => "R", "\\\n" => "N", "\\\t" => "T"]:\n -N\n \+RN$@');

        $constraint = new SameStringsConstraint("\r\n");
        $constraint->evaluate("\n");
    }
}
