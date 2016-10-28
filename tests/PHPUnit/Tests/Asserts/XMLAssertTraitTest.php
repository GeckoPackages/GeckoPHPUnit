<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\XMLAssertTrait;

/**
 * @requires PHP 5.4
 *
 * @internal
 *
 * @author SpacePossum
 */
final class XMLAssertTraitTest extends AbstractGeckoPHPUnitTest
{
    use XMLAssertTrait;

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp /^Failed asserting that integer\#1234 is valid XML.$/
     */
    public function testAssertXMLValidInvalidInput()
    {
        $this->assertXMLValid(1234);
    }

    public function testAssertXMLValid()
    {
        $this->assertXMLValid('<note><test>Test</test></note>');
    }

    public function testAssertXMLMatchesXSD()
    {
        $this->assertXMLMatchesXSD(file_get_contents($this->getAssetsDir().'XLIFF/xliff-core-1.2-strict.xsd'), file_get_contents($this->getAssetsDir().'XLIFF/xliff_sample.xml'));
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that test string is valid XML.[\n]\[fatal 4\] .+.$#
     */
    public function testAssertXMLValidFailure()
    {
        $this->assertXMLValid('test string');
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that <note><test>Test</test></note> matches XSD.[\n]\[error 1845\] .+.$#
     */
    public function testAssertXMLMatchesXSDNotMatchingXML()
    {
        $this->assertXMLMatchesXSD(file_get_contents($this->getAssetsDir().'XLIFF/xliff-core-1.2-strict.xsd'), '<note><test>Test</test></note>');
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that b matches XSD.[\n]\[fatal 4\] .+.$#
     */
    public function testAssertXMLMatchesXSDInvalidXMLInvalidXSD()
    {
        $this->assertXMLMatchesXSD('a', 'b');
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp /^Argument #1 \(integer#1\) of XMLAssertTrait::assertXMLMatchesXSD\(\) must be a string.$/
     */
    public function testAssertXMLMatchesXSDInvalidInputXSD()
    {
        $this->assertXMLMatchesXSD(1, '');
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# matches XSD.$#
     */
    public function testAssertXMLMatchesXSDInvalidInputXML()
    {
        $this->assertXMLMatchesXSD('', new \stdClass());
    }
}
