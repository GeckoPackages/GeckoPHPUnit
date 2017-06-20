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

use GeckoPackages\PHPUnit\Asserts\ScalarAssertTrait;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class ScalarAssertTraitTest extends GeckoTestCase
{
    use ScalarAssertTrait;

    public function testAssertArray()
    {
        $this->assertArray([]);
    }

    public function testAssertBool()
    {
        $this->assertBool(true);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that DateTime\# is of type bool\.$#
     */
    public function testAssertBoolFail()
    {
        $this->assertBool(new \DateTime());
    }

    public function testAssertFloat()
    {
        $this->assertFloat(1.0);
    }

    public function testAssertInt()
    {
        $this->assertInt(1);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that double\#1 is of type int\.$#
     */
    public function testAssertIntFail()
    {
        $this->assertInt(1.0);
    }

    public function testAssertScalar()
    {
        $this->assertScalar(1);
    }

    public function testAssertString()
    {
        $this->assertString('test');
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

    public function testAssertNotScalar()
    {
        $this->assertNotScalar(new \stdClass());
    }

    public function testAssertNotString()
    {
        $this->assertNotString(false);
    }
}
