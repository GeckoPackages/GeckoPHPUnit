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

class FileExistsTraitTest extends AbstractGeckoPHPUnitTest
{
    use FileExistsTrait;

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
        // make symlinks if needed
        if (!file_exists($this->getAssetsDir().'test_link') && false === @symlink($this->getAssetsDir().'_link_test_target_dir_', $this->getAssetsDir().'test_link')) {
            $error = error_get_last();
            $this->fail(
                sprintf(
                    'Failed to create symlink "%s" for target "%s".%s',
                    $this->getAssetsDir().'test_link',
                    $this->getAssetsDir().'_link_test_target_dir_',
                    $error ? $error['message'] : ''
                )
            );
        }

        if (!file_exists($this->getAssetsDir().'test_link_file') && false === symlink($this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp', $this->getAssetsDir().'test_link_file')) {
            $error = error_get_last();
            $this->fail(
                sprintf(
                    'Failed to create symlink "%s" for target "%s".%s',
                    $this->getAssetsDir().'test_link_file',
                    $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
                    $error ? $error['message'] : ''
                )
            );
        }

        return [
            [true, __FILE__],
            [true, $this->getAssetsDir().'test_link_file'], // sym link to file
            [false, $this->getAssetsDir().'test_link'], // sym link to directory
            [false, __FILE__.time()],
            [false, __DIR__],
        ];
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessage Argument #1 (integer#123) of FileExistsTrait::assertFileExists() must be a string.
     */
    public function testFailIntMessage()
    {
        $this->assertFileExists(123);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessage Argument #1 (stdClass#) of FileExistsTrait::assertFileExists() must be a string.
     */
    public function testFailStdClassMessage()
    {
        $this->assertFileExists(new \stdClass());
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessage Argument #1 (NULL#) of FileExistsTrait::assertFileExists() must be a string.
     */
    public function testFailNullMessage()
    {
        $this->assertFileExists(null);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessage Failed asserting that file "_no_file_" exists.
     */
    public function testNoFileFoundMessage()
    {
        $this->assertFileExists('_no_file_');
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #Failed asserting that directory "/.*PHPUnit/tests/PHPUnit/Tests/Asserts" exists as file.#
     */
    public function testFailDirectoryMessage()
    {
        $this->assertFileExists(__DIR__);
    }
}
