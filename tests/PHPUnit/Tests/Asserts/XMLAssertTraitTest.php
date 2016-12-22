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
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class XMLAssertTraitTest extends AbstractGeckoPHPUnitTest
{
    use XMLAssertTrait;

    public function testAssertXMLMatchesXSD()
    {
        $this->assertXMLMatchesXSD(file_get_contents($this->getAssetsDir().'XLIFF/xliff-core-1.2-strict.xsd'), file_get_contents($this->getAssetsDir().'XLIFF/xliff_sample.xml'));
    }

    public function testAssertXMLMatchesXSDFail()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that <note><test>Test</test></note> matches XSD.[\n]\[error 1845\] .+.$#');

        $this->assertXMLMatchesXSD(file_get_contents($this->getAssetsDir().'XLIFF/xliff-core-1.2-strict.xsd'), '<note><test>Test</test></note>');
    }

    public function testAssertXMLMatchesXSDInvalidInputXML()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# matches XSD.$#');

        $this->assertXMLMatchesXSD('', new \stdClass());
    }

    public function testAssertXMLMatchesXSDInvalidInputXSD()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#1 \(integer\#1\) of XMLAssertTrait::assertXMLMatchesXSD\(\) must be a string.$#');

        $this->assertXMLMatchesXSD(1, '');
    }

    public function testAssertXMLMatchesXSDInvalidXMLInvalidXSD()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that b matches XSD.[\n]\[fatal 4\] .+.$#');

        $this->assertXMLMatchesXSD('a', 'b');
    }

    public function testAssertXMLValid()
    {
        $this->assertXMLValid('<note><test>Test</test></note>');
    }

    public function testAssertXMLValidFail()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that test string is valid XML.[\n]\[fatal 4\] .+.$#');

        $this->assertXMLValid('test string');
    }

    public function testAssertXMLValidInvalidInput()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1234 is valid XML.$#');

        $this->assertXMLValid(1234);
    }
}
