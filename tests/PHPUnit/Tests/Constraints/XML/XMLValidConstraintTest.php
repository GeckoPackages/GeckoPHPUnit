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

use GeckoPackages\PHPUnit\Constraints\XML\XMLValidConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class XMLValidConstraintTest extends AbstractGeckoPHPUnitTest
{
    public function testXMLValidConstraint()
    {
        $constraint = new XMLValidConstraint();
        $this->assertTrue($constraint->evaluate('<a></a>', '', true));
    }

    public function testXMLValidConstraintBasics()
    {
        $constraint = new XMLValidConstraint();
        $this->assertSame(1, $constraint->count());
        $this->assertSame('is valid XML', $constraint->toString());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that boolean\# is valid XML\.$#
     */
    public function testXMLValidConstraintFalse()
    {
        $constraint = new XMLValidConstraint();
        $constraint->evaluate(false);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is valid XML\.$#
     */
    public function testXMLValidConstraintInt()
    {
        $constraint = new XMLValidConstraint();
        $constraint->evaluate(1);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that <a></b> is valid XML.[\n]\[error \d{1,}\](?s).*\.$#
     */
    public function testXMLValidConstraintInvalidXML()
    {
        $constraint = new XMLValidConstraint();
        $constraint->evaluate('<a></b>');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is valid XML\.$#
     */
    public function testXMLValidConstraintNull()
    {
        $constraint = new XMLValidConstraint();
        $constraint->evaluate(null);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is valid XML\.$#
     */
    public function testXMLValidConstraintObject()
    {
        $constraint = new XMLValidConstraint();
        $constraint->evaluate(new \stdClass());
    }
}
