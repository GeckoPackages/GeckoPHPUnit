<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\ScalarConstraint;

/**
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class ScalarConstraintTest extends AbstractGeckoPHPUnitTest
{
    public function testArray()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1 is of type array.$#');

        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_ARRAY);
        $this->assertTrue($constraint->evaluate(array(), '', true));
        $this->assertFalse($constraint->evaluate(1, '', false));
    }

    public function testBool()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is of type bool.$#');

        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_BOOL);
        $this->assertTrue($constraint->evaluate(true, '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    public function testFloat()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# is of type float.$#');

        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_FLOAT);
        $this->assertTrue($constraint->evaluate(1.1, '', true));
        $this->assertFalse($constraint->evaluate(new \stdClass(), '', false));
    }

    public function testInt()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is of type int.$#');

        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_INT);
        $this->assertTrue($constraint->evaluate(1, '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    public function testNullType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('#^Unknown ScalarConstraint type "null" provided.$#');

        new ScalarConstraint(null);
    }

    public function testString()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is of type string.$#');

        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_STRING);
        $this->assertTrue($constraint->evaluate('', '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    public function testToString()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_ARRAY);
        $this->assertSame('is of given scalar type.', $constraint->toString());
    }

    public function testScalar()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is of type scalar.$#');

        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_SCALAR);
        $this->assertSame(1, $constraint->count());
        $this->assertTrue($constraint->evaluate(1, '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    public function testUnknownValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('#^Unknown ScalarConstraint type "integer\#123456789" provided.$#');

        new ScalarConstraint(123456789);
    }
}
