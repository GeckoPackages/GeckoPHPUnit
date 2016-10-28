<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\ScalarAssertTrait;

/**
 * @requires PHP 5.4
 *
 * @internal
 *
 * @author SpacePossum
 */
final class ScalarAssertTraitTest extends \PHPUnit_Framework_TestCase
{
    use ScalarAssertTrait;

    public function testAssertScalar()
    {
        $this->assertScalar(1);
    }

    public function testAssertInt()
    {
        $this->assertInt(1);
    }

    public function testAssertBool()
    {
        $this->assertBool(true);
    }

    public function testAssertString()
    {
        $this->assertString('test');
    }

    public function testAssertStringIsEmpty()
    {
        $this->assertStringIsEmpty('');
    }

    public function testAssertStringIsNotEmpty()
    {
        $this->assertStringIsNotEmpty('   a');
    }

    public function testAssertStringIsWhiteSpace()
    {
        $this->assertStringIsWhiteSpace("\n\t  \n");
    }

    public function testAssertStringIsNotWhiteSpace()
    {
        $this->assertStringIsNotWhiteSpace("\n\t  \n1");
    }

    public function testAssertFloat()
    {
        $this->assertFloat(1.0);
    }

    public function testAssertArray()
    {
        $this->assertArray([]);
    }

    public function testAssertNotScalar()
    {
        $this->assertNotScalar(new \stdClass());
    }

    public function testAssertNotArray()
    {
        $this->assertNotArray(1);
    }

    public function testAssertNotBool()
    {
        $this->assertNotBool('true');
    }

    public function testAssertNotFloat()
    {
        $this->assertNotFloat(-9);
    }

    public function testAssertNotInt()
    {
        $this->assertNotInt('a');
    }

    public function testAssertNotString()
    {
        $this->assertNotString(false);
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that "1" \(double\) is of type int.$#
     */
    public function testAssertIntFail()
    {
        $this->assertInt(1.0);
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that "\[\?\]" \(DateTime\) is of type bool.$#
     */
    public function testAssertBoolFail()
    {
        $this->assertBool(new \DateTime());
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a string is not empty.$#
     */
    public function testAssertStringIsNotEmptyFail()
    {
        $this->assertStringIsNotEmpty('');
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a string is empty.$#
     */
    public function testAssertStringIsWhiteSpaceFail()
    {
        $this->assertStringIsWhiteSpace('test');
    }
}
