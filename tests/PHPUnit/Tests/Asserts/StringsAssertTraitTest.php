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
 * @requires PHPUnit 5.2
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

    public function testAssertNotSameStringsFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that two strings are not identical.$#');

        $this->assertNotSameStrings("\r\n", "\r\n");
    }

    public function testAssertSameStrings()
    {
        $this->assertSameStrings('a', 'a');
    }

    public function testAssertSameStringsFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that two strings are identical.$#');

        $this->assertSameStrings('a', 'b');
    }

    public function testAssertStringIsEmpty()
    {
        $this->assertStringIsEmpty('');
    }

    public function testAssertStringIsEmptyFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that a string is empty.$#');

        $this->assertStringIsEmpty('a');
    }

    public function testAssertStringIsNotEmpty()
    {
        $this->assertStringIsNotEmpty('   a');
    }

    public function testAssertStringIsNotEmptyFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that a string is not empty.$#');

        $this->assertStringIsNotEmpty('');
    }

    public function testAssertStringIsNotWhiteSpace()
    {
        $this->assertStringIsNotWhiteSpace("\n\t  \n1");
    }

    public function testAssertStringIsNotWhiteSpaceFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that a string is not empty.$#');

        $this->assertStringIsNotWhiteSpace("\n\t  \n");
    }

    public function testAssertStringIsWhiteSpace()
    {
        $this->assertStringIsWhiteSpace("\n\t  \n");
    }

    public function testAssertStringIsWhiteSpaceFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that a string is empty.$#');

        $this->assertStringIsWhiteSpace('test');
    }
}
