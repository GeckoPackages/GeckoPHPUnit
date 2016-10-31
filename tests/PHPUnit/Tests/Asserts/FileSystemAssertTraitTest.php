<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Asserts\FileSystemAssertTrait;

/**
 * @requires PHP 5.4
 *
 * @internal
 *
 * @author SpacePossum
 */
final class FileSystemAssertTraitTest extends AbstractGeckoPHPUnitFileTest
{
    use FileSystemAssertTrait;

    public function testAssertDirectoryEmpty()
    {
        $dir = $this->getAssetsDir().time();
        mkdir($dir);
        $this->assertDirectoryEmpty($dir);
        rmdir($dir);
        $this->assertDirectoryNotEmpty(__DIR__);
    }

    public function testAssertDirectoryExists()
    {
        $this->assertDirectoryExists(__DIR__);
        $this->assertDirectoryNotExists(__DIR__.'/no_such_dir/');
        $this->assertDirectoryNotExists(__FILE__);
    }

    /**
     * @param string $permission
     * @param string $file
     *
     * @dataProvider provideFiles
     */
    public function testAssertFileHasPermissions($permission, $file)
    {
        $this->assertFileHasPermissions($permission, $file);
    }

    public function provideFiles()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        return array(
            array(0775, __DIR__),
            array('0775', __DIR__),
            array('509', __DIR__),
            array('drwxrwxr-x', __DIR__),
            array(0664, __FILE__),
            array(100664, __FILE__),
            array('-rw-rw-r--', __FILE__),
            array('lrwxrwxrwx', $link),
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/Tests/Asserts 0775 permissions are equal to 0664.$#
     */
    public function testAssertFileHasPermissionsFailureDir()
    {
        $this->assertFileHasPermissions(0664, __DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php 0664 permissions are equal to 0555.$#
     */
    public function testAssertFileHasPermissionsFailureFile()
    {
        $this->assertFileHasPermissions(0555, __FILE__);
    }

    public function testAssertFileIsLink()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $this->assertFileIsLink($link);
        $this->assertFileIsNotLink(__FILE__);
    }

    /**
     * @param int $mask
     *
     * @dataProvider provideFileMasks
     */
    public function testAssertFilePermissionMask($mask)
    {
        $this->assertFilePermissionMask($mask, __FILE__);
    }

    public function provideFileMasks()
    {
        return array(
            array(0664),
            array(0000),
            array(0004),
            array(0060),
            array(0064),
            array(0600),
            array(0604),
            array(0660),
        );
    }

    public function testAssertFilePermissionLink()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $this->assertFilePermissionMask(0664, $link);
    }

    /**
     * @param int $mask
     *
     * @dataProvider provideFilePermissionNotMask
     */
    public function testAssertFilePermissionNotMask($mask)
    {
        $this->assertFilePermissionNotMask($mask, __FILE__);
    }

    public function provideFilePermissionNotMask()
    {
        return array(
            array(0007),
            array(0005),
            array(0055),
            array(0777),
            array(0005),
            array(0050),
            array(0764),
            array(0700),
            array(0704),
            array(0650),
            array(0764),
        );
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts is an empty directory.$#
     */
    public function testAssertDirectoryEmptyFail()
    {
        $this->assertDirectoryEmpty(__DIR__);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that a/b/c/d is a directory.$#
     */
    public function testAssertDirectoryExistsFail()
    {
        $this->assertDirectoryExists('a/b/c/d');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php is a directory.$#
     */
    public function testAssertDirectoryExistsFile()
    {
        $this->assertDirectoryExists(__FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that null is a directory.$#
     */
    public function testAssertDirectoryExistsFailNull()
    {
        $this->assertDirectoryExists(null);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php is a link.$#
     */
    public function testAssertFileIsLinkFailFile()
    {
        $this->assertFileIsLink(__FILE__);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts is a link.$#
     */
    public function testAssertFileIsLinkFailDirectory()
    {
        $this->assertFileIsLink(__DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#678 is a link.$#
     */
    public function testAssertFileIsLinkFailInteger()
    {
        $this->assertFileIsLink(678);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(null\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string.$#
     */
    public function testAssertFileHasPermissionsFailNull()
    {
        $this->assertFileHasPermissions(null, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(stdClass\#\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string.$#
     */
    public function testAssertFileHasPermissionsFailObject()
    {
        $this->assertFileHasPermissions(new \stdClass(), __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^FileSystemAssertTrait::assertFileHasPermissions\(\) Permission to match "invalidrwx" is not formatted correctly.$#
     */
    public function testAssertFileHasPermissionsFailInvalidPermissionString()
    {
        $this->assertFileHasPermissions('invalidrwx', __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(integer\#-1\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string.$#
     */
    public function testAssertFileHasPermissionsFailInvalidPermissionValue()
    {
        $this->assertFileHasPermissions(-1, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that null permissions are equal.$#
     */
    public function testAssertFileHasPermissionsFailFile()
    {
        $this->assertFileHasPermissions(0777, null);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php 100664 permissions matches mask 777.$#
     */
    public function testAssertFilePermissionMaskFail()
    {
        $this->assertFilePermissionMask(0777, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Asserts 40775 permissions does not match mask 755.$#
     */
    public function testAssertFilePermissionNotMaskFail()
    {
        $this->assertFilePermissionNotMask(0755, __DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(null\) of FileSystemAssertTrait::assertFilePermissionMask\(\) must be an int.$#
     */
    public function testAssertFilePermissionMaskInvalidArg1()
    {
        $this->assertFilePermissionMask(null, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#89 permissions matches mask.$#
     */
    public function testAssertFilePermissionMaskInvalidArg2()
    {
        $this->assertFilePermissionMask(0777, 89);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that not file or directory\#no_file permissions matches mask.$#
     */
    public function testAssertFilePermissionMaskInvalidArg2File()
    {
        $this->assertFilePermissionMask(0777, 'no_file');
    }
}
