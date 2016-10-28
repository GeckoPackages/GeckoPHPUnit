<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * @requires PHP 5.4
 *
 * @internal
 *
 * @author SpacePossum
 */
final class AssertHelperTest extends AbstractGeckoPHPUnitTest
{
    public static function setUpBeforeClass()
    {
        require_once __DIR__.'/AssertHelperTestDummies.php';
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^FileExistsAssertTrait::assertFileExists\(\) Relies on missing method "assertThat".$#
     */
    public function testMissingMethod()
    {
        $dummy = new TestDummy();
        $dummy->assertFileExists(__FILE__);
    }
}
