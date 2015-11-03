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

class TestDummy
{
    use FileExistsTrait;
    use FileSystemAssertTrait;
    use ScalarAssertTrait;
    use XMLAssertTrait;
}

class TestDummy2
{
    use FileSystemAssertTrait;
}

class AssertHelperTest extends AbstractGeckoPHPUnitTest
{
    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessage FileExistsTrait::assertFileExists() Relies on missing method "assertThat".
     */
    public function testMissingMethod()
    {
        $dummy = new TestDummy();
        $dummy->assertFileExists(__FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessage FileSystemAssertTrait::assertFileIsLink() Relies on missing methods "assertThat", "assertFileExists".
     */
    public function testMissingMethods()
    {
        $dummy = new TestDummy2();
        $dummy->assertFileIsLink(__FILE__);
    }
}
