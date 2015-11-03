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
        if (!file_exists($this->getAssetsDir().'test_link')) {
            symlink($this->getAssetsDir().'_link_test_target_dir_', $this->getAssetsDir().'test_link');
        }

        if (!file_exists($this->getAssetsDir().'test_link_file')) {
            symlink($this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp', $this->getAssetsDir().'test_link_file');
        }

        return array(
            array(true, __FILE__),
            array(true, $this->getAssetsDir().'test_link_file'), // sym link to file
            array(false, $this->getAssetsDir().'test_link'), // sym link to directory
            array(false, __FILE__.time()),
            array(false, __DIR__),
        );
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
