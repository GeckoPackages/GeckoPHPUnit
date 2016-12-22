<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\FileExistsAssertTrait;

/**
 * @requires PHP 5.4
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class FileExistsAssertTraitTest extends AbstractGeckoPHPUnitFileTest
{
    use FileExistsAssertTrait;

    /**
     * @param string $expected
     * @param string $file
     *
     * @dataProvider provideFiles
     */
    public function testFileExists($expected, $file)
    {
        if ($expected) {
            $this->assertFileExists($file);
        } else {
            $this->assertFileNotExists($file);
        }
    }

    public function provideFiles()
    {
        $dirLink = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $dirLink
        );

        $fileLink = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $fileLink
        );

        return array(
            array(true, __FILE__),
            array(true, $fileLink),
            array(false, $dirLink),
            array(false, __FILE__.time()),
            array(false, __DIR__),
        );
    }

    public function testAssertFileExistsDirectory()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts is a file.$#');

        $this->assertFileExists(__DIR__);
    }

    public function testAssertFileExistsInt()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#123 is a file.$#');

        $this->assertFileExists(123);
    }

    public function testAssertFileExistsNoFile()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that _no_file_ is a file.$#');

        $this->assertFileExists('_no_file_');
    }

    public function testAssertFileExistsNull()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is a file.$#');

        $this->assertFileExists(null);
    }

    public function testAssertFileExistsObject()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# is a file.$#');

        $this->assertFileExists(new \stdClass());
    }
}
