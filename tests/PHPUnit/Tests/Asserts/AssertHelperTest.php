<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\FileExistsTrait;
use GeckoPackages\PHPUnit\Asserts\FileSystemAssertTrait;
use GeckoPackages\PHPUnit\Asserts\ScalarAssertTrait;
use GeckoPackages\PHPUnit\Asserts\XMLAssertTrait;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class TestDummy
{
    use FileExistsTrait;
    use FileSystemAssertTrait;
    use ScalarAssertTrait;
    use XMLAssertTrait;
}

/**
 * @internal
 */
final class TestDummy2
{
    use FileSystemAssertTrait;
}

/**
 * @requires PHP 5.4
 *
 * @internal
 */
final class AssertHelperTest extends AbstractGeckoPHPUnitTest
{
    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^FileExistsTrait::assertFileExists\(\) Relies on missing method "assertThat".$#
     */
    public function testMissingMethod()
    {
        $dummy = new TestDummy();
        $dummy->assertFileExists(__FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^FileSystemAssertTrait::assertFileIsLink\(\) Relies on missing methods "assertThat", "assertFileExists".$#
     */
    public function testMissingMethods()
    {
        $dummy = new TestDummy2();
        $dummy->assertFileIsLink(__FILE__);
    }
}
