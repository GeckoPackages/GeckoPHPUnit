<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\StringsAssertTrait;

/**
 * @requires PHP 5.4
 *
 * @internal
 *
 * @author SpacePossum
 */
final class StringsAssertTraitTest extends AbstractGeckoPHPUnitTest
{
    use StringsAssertTrait;

    public function testAssertNotSameStrings()
    {
        $this->assertNotSameStrings("\n", "\r\n");
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that two strings are not identical\.$#
     */
    public function testAssertNotSameStringsFail()
    {
        $this->assertNotSameStrings("\r\n", "\r\n");
    }

    public function testAssertSameStrings()
    {
        $this->assertSameStrings('a', 'a');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that two strings are identical\.$#
     */
    public function testAssertSameStringsFail()
    {
        $this->assertSameStrings('a', 'b');
    }

    public function testAssertStringIsEmpty()
    {
        $this->assertStringIsEmpty('');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a string is empty\.$#
     */
    public function testAssertStringIsEmptyFail()
    {
        $this->assertStringIsEmpty('a');
    }

    public function testAssertStringIsNotEmpty()
    {
        $this->assertStringIsNotEmpty('   a');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a string is not empty\.$#
     */
    public function testAssertStringIsNotEmptyFail()
    {
        $this->assertStringIsNotEmpty('');
    }

    public function testAssertStringIsNotWhiteSpace()
    {
        $this->assertStringIsNotWhiteSpace("\n\t  \n1");
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a string is not empty\.$#
     */
    public function testAssertStringIsNotWhiteSpaceFail()
    {
        $this->assertStringIsNotWhiteSpace("\n\t  \n");
    }

    public function testAssertStringIsWhiteSpace()
    {
        $this->assertStringIsWhiteSpace("\n\t  \n");
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a string is empty\.$#
     */
    public function testAssertStringIsWhiteSpaceFail()
    {
        $this->assertStringIsWhiteSpace('test');
    }
}
