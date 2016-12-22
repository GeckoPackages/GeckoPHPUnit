<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\RangeAssertTrait;

/**
 * @requires PHP 5.4
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class RangeAssertTraitTest extends \PHPUnit_Framework_TestCase
{
    use RangeAssertTrait;

    public function testAssertNumberInRange()
    {
        $this->assertNumberInRange(1, 3, 2);
    }

    public function testAssertNumberInRangeFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that -0.500 is in range \(1.100, 3.200\).$#');

        $this->assertNumberInRange(1.1, 3.2, -0.5);
    }

    public function testAssertNumberNotInRange()
    {
        $this->assertNumberNotInRange(1, 3, 4);
    }

    public function testAssertNumberNotInRangeInvalidArgumentLower()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#1 \(null\) of RangeAssertTrait::assertNumberNotInRange\(\) must be a float or int.$#');

        $this->assertNumberNotInRange(null, 3, 4);
    }

    public function testAssertNumberNotInRangeInvalidArgumentUpper()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#2 \(string\#_invalid_\) of RangeAssertTrait::assertNumberNotInRange\(\) must be a float or int.$#');

        $this->assertNumberNotInRange(3, '_invalid_', 4);
    }

    public function testAssertNumberNotOnRange()
    {
        $this->assertNumberNotOnRange(-3, -2, -1);
    }

    public function testAssertNumberOnRange()
    {
        $this->assertNumberOnRange(1, 3, 3);
    }

    public function testAssertNumberOnRangeInvalidRange()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^RangeAssertTrait::assertNumberOnRange\(\) lower boundary 5 must be smaller than upper boundary -5.500.$#');

        $this->assertNumberOnRange(5, -5.5, 6);
    }

    public function testAssertUnsignedInt()
    {
        $this->assertUnsignedInt(4);
    }

    public function testAssertUnsignedIntFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that -4 is unsigned int.$#');

        $this->assertUnsignedInt(-4);
    }
}
