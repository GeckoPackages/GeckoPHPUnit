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

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that boolean\# matches XSD\.$#
     */
    public function testXMLValidConstraintFalse()
    {
        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(false);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 matches XSD\.$#
     */
    public function testXMLValidConstraintInt()
    {
        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(1);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that <a></b> matches XSD.[\n]\[error \d{1,}\](?s).*$#
     */
    public function testXMLValidConstraintInvalidXML()
    {
        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate('<a></b>');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that <a></a> matches XSD.[\n]\[error \d{1,}\](?s).*\.$#
     */
    public function testXMLValidConstraintNotMatchingXML()
    {
        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate('<a></a>');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null matches XSD\.$#
     */
    public function testXMLValidConstraintNull()
    {
        $constraint = new XMLMatchesXSDConstraint($this->getXSD());
        $constraint->evaluate(null);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# matches XSD\.$#
     */
    public function testXMLValidConstraintObject()
    {
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
