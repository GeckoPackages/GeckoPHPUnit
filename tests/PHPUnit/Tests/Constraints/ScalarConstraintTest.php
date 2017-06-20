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

use GeckoPackages\PHPUnit\Constraints\ScalarConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class ScalarConstraintTest extends AbstractGeckoPHPUnitTest
{
    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is of type array\.$#
     */
    public function testArray()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_ARRAY);
        $this->assertTrue($constraint->evaluate([], '', true));
        $this->assertFalse($constraint->evaluate(1, '', false));
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is of type bool\.$#
     */
    public function testBool()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_BOOL);
        $this->assertTrue($constraint->evaluate(true, '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is of type float\.$#
     */
    public function testFloat()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_FLOAT);
        $this->assertTrue($constraint->evaluate(1.1, '', true));
        $this->assertFalse($constraint->evaluate(new \stdClass(), '', false));
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is of type int\.$#
     */
    public function testInt()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_INT);
        $this->assertTrue($constraint->evaluate(1, '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Unknown ScalarConstraint type "null" provided\.$#
     */
    public function testNullType()
    {
        new ScalarConstraint(null);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is of type string\.$#
     */
    public function testString()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_STRING);
        $this->assertTrue($constraint->evaluate('', '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    public function testToString()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_ARRAY);
        $this->assertSame('is of given scalar type.', $constraint->toString());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is of type scalar\.$#
     */
    public function testScalar()
    {
        $constraint = new ScalarConstraint(ScalarConstraint::TYPE_SCALAR);
        $this->assertSame(1, $constraint->count());
        $this->assertTrue($constraint->evaluate(1, '', true));
        $this->assertFalse($constraint->evaluate(null, '', false));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Unknown ScalarConstraint type "integer\#123456789" provided\.$#
     */
    public function testUnknownValue()
    {
        new ScalarConstraint(123456789);
    }
}
