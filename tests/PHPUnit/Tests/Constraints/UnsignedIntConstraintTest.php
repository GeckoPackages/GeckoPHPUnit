<?php

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

    public function provideFailCases()
    {
        return array(
            array(-1),
            array(0.1),
            array(1.5),
            array('123'),
            array(false),
            array(null),
            array(new \stdClass()),
        );
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is unsigned int.$#
     */
    public function testUnsignedIntConstraintFailMessage()
    {
        $constraint = new UnsignedIntConstraint();
        $constraint->evaluate(null);
    }
}
