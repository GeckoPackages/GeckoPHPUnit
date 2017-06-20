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

use GeckoPackages\PHPUnit\Constraints\UnsignedIntConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class UnsignedIntConstraintTest extends AbstractGeckoPHPUnitTest
{
    public function testUnsignedIntConstraint()
    {
        $constraint = new UnsignedIntConstraint();
        $this->assertSame('is unsigned int', $constraint->toString());
        $this->assertTrue($constraint->evaluate(0, '', true));
        $this->assertTrue($constraint->evaluate(time(), '', true));
        $this->assertTrue($constraint->evaluate(PHP_INT_MAX, '', true));
    }

    /**
     * @param mixed $invalid
     *
     * @dataProvider provideFailCases
     */
    public function testUnsignedIntConstraintFail($invalid)
    {
        $constraint = new UnsignedIntConstraint();
        $this->assertFalse($constraint->evaluate($invalid, '', true));
    }

    public function provideFailCases(): array
    {
        return [
            [-1],
            [0.1],
            [1.5],
            ['123'],
            [false],
            [null],
            [new \stdClass()],
        ];
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is unsigned int\.$#
     */
    public function testUnsignedIntConstraintFailMessage()
    {
        $constraint = new UnsignedIntConstraint();
        $constraint->evaluate(null);
    }
}
