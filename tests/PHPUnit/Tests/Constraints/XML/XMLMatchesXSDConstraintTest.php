<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\XML\XMLMatchesXSDConstraint;

/**
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class XMLMatchesXSDConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    public function testAssertXMLMatchesXSD()
    {
        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $this->assertTrue($constraint->evaluate(file_get_contents($this->getAssetsDir().'XLIFF/xliff_sample.xml'), '', true));
    }

    public function testXMLValidConstraintBasics()
    {
        $constraint = new XMLMatchesXSDConstraint('');
        $this->assertSame(1, $constraint->count());
        $this->assertSame('matches XSD', $constraint->toString());
    }

    public function testXMLValidConstraintFalse()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that boolean\# matches XSD.$#');

        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(false);
    }

    public function testXMLValidConstraintInt()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1 matches XSD.$#');

        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(1);
    }

    public function testXMLValidConstraintInvalidXML()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that <a></b> matches XSD.[\n]\[error \d{1,}\](?s).*$#');

        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate('<a></b>');
    }

    public function testXMLValidConstraintNotMatchingXML()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that <a></a> matches XSD.[\n]\[error \d{1,}\](?s).*$#');

        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate('<a></a>');
    }

    public function testXMLValidConstraintNull()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null matches XSD.$#');

        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(null);
    }

    public function testXMLValidConstraintObject()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# matches XSD.$#');

        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(new \stdClass());
    }

    /**
     * @return string
     */
    private function getXSD()
    {
        return file_get_contents($this->getAssetsDir().'XLIFF/xliff-core-1.2-strict.xsd');
    }
}
