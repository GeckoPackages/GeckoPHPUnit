<?php

declare(strict_types=1);

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\NumberRangeConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class NumberRangeConstraintTest extends AbstractGeckoPHPUnitTest
{
    public function testNumberRangeConstraintInRange()
    {
        $lower = -1;
        $upper = 5;
        $constraint = new NumberRangeConstraint($lower, $upper, true);

        $this->assertSame('is in range', $constraint->toString());

        for ($i = $lower; $i <= $upper; ++$i) {
            $this->assertTrue($constraint->evaluate($i, '', true));
        }
    }

    public function testNumberRangeConstraintWithInRange()
    {
        $lower = 1;
        $upper = 3;
        $constraint = new NumberRangeConstraint($lower, $upper, false);

        $this->assertSame('is within range', $constraint->toString());

        for ($i = $lower + 1; $i < $upper; ++$i) {
            $this->assertTrue($constraint->evaluate($i, '', true));
        }
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that 1 is within range \(0, 1\)\.$#
     */
    public function testNumberRangeConstraintFailOnRange()
    {
        $upper = 1;
        $constraint = new NumberRangeConstraint(0, $upper, false);
        $constraint->evaluate($upper);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that 2\.500 is in range \[0\.500, 1\.500\]\.$#
     */
    public function testNumberRangeConstraintFailOutOfRange()
    {
        $upper = 1.5;
        $constraint = new NumberRangeConstraint(0.5, $upper, true);
        $constraint->evaluate($upper + 1);
    }
}
