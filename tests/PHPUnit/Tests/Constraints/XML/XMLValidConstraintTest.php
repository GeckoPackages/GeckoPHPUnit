<?php

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
 * @requires PHPUnit 5.2
 *
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

    public function testXMLValidConstraintFalse()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that boolean\# is valid XML.$#');

        $constraint = new XMLValidConstraint();
        $constraint->evaluate(false);
    }

    public function testXMLValidConstraintInt()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1 is valid XML.$#');

        $constraint = new XMLValidConstraint();
        $constraint->evaluate(1);
    }

    public function testXMLValidConstraintInvalidXML()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that <a></b> is valid XML.[\n]\[error \d{1,}\](?s).*$#');

        $constraint = new XMLValidConstraint();
        $constraint->evaluate('<a></b>');
    }

    public function testXMLValidConstraintNull()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is valid XML.$#');

        $constraint = new XMLValidConstraint();
        $constraint->evaluate(null);
    }

    public function testXMLValidConstraintObject()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# is valid XML.$#');

        $constraint = new XMLValidConstraint();
        $constraint->evaluate(new \stdClass());
    }
}
