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

use GeckoPackages\PHPUnit\Asserts\FileExistsAssertTrait;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class FileExistsAssertTraitTest extends AbstractGeckoPHPUnitFileTest
{
    use FileExistsAssertTrait;

    /**
     * @param bool   $expected
     * @param string $file
     *
     * @dataProvider provideFiles
     */
    public function testFileExists(bool $expected, string $file)
    {
        $expected
            ? $this->assertFileExists($file)
            : $this->assertFileNotExists($file)
        ;
    }

    public function provideFiles(): array
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

        return [
            [true, __FILE__],
            [true, $fileLink],
            [false, $dirLink],
            [false, __FILE__.time()],
            [false, __DIR__],
        ];
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts is a file\.$#
     */
    public function testAssertFileExistsDirectory()
    {
        $this->assertFileExists(__DIR__);
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp /^Failed asserting that integer\#123 is a file\.$/
     */
    public function testAssertFileExistsInt()
    {
        $this->assertFileExists(123);
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp /^Failed asserting that _no_file_ is a file\.$/
     */
    public function testAssertFileExistsNoFile()
    {
        $this->assertFileExists('_no_file_');
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp /^Failed asserting that null is a file\.$/
     */
    public function testAssertFileExistsNull()
    {
        $this->assertFileExists(null);
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp /^Failed asserting that stdClass\# is a file\.$/
     */
    public function testAssertFileExistsObject()
    {
        $this->assertFileExists(new \stdClass());
    }
}
