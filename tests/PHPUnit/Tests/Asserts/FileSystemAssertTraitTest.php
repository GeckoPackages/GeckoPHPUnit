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

final class FileSystemAssertTraitTest extends AbstractGeckoPHPUnitTest
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
        // make symlink if needed
        if (!file_exists($this->getAssetsDir().'test_link')) {
            symlink($this->getAssetsDir().'_link_test_target_dir_', $this->getAssetsDir().'test_link');
        }

        return [
            [0775, __DIR__],
            ['0775', __DIR__],
            ['509', __DIR__],
            ['drwxrwxr-x', __DIR__],
            [0664, __FILE__],
            [100664, __FILE__],
            ['-rw-rw-r--', __FILE__],
            ['lrwxrwxrwx', $this->getAssetsDir().'test_link'],
        ];
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that permission 775 of directory "/.*PHPUnit/tests/PHPUnit/Tests/Asserts" is identical to permission 664.$#
     */
    public function testAssertFileHasPermissionsFailureDir()
    {
        $this->assertFileHasPermissions(0664, __DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that permission 664 of file "/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php" is identical to permission 555.$#
     */
    public function testAssertFileHasPermissionsFailureFile()
    {
        $this->assertFileHasPermissions(0555, __FILE__);
    }

    public function testAssertFileIsLink()
    {
        // make symlink if needed
        if (!file_exists($this->getAssetsDir().'test_link')) {
            symlink($this->getAssetsDir().'_link_test_target_dir_', $this->getAssetsDir().'test_link');
        }

        $this->assertFileIsLink($this->getAssetsDir().'test_link');
        $this->assertFileIsNotLink(__FILE__);
    }

    /**
     * @param string $expected
     * @param string $input
     *
     * @dataProvider provideFilePermissions
     */
    public function testGetFilePermissionsAsString($expected, $input)
    {
        $reflection = new \ReflectionClass($this);
        $method = $reflection->getMethod('getFilePermissionsAsString');
        $method->setAccessible(true);
        $this->assertSame($expected, $method->invokeArgs($this, [$input]));
    }

    public function provideFilePermissions()
    {
        return [
            ['drwxrwxr-x', fileperms(__DIR__)],
            ['urwxrwxrwx', 0777],
            ['prwxrwxrwx', 010777],
            ['crwxrwxrwx', 020777],
            ['brwxrwxrwx', 060777],
            ['srwxrwxrwx', 0140777],
        ];
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
        return [
            [0664],
            [0000],
            [0004],
            [0060],
            [0064],
            [0600],
            [0604],
            [0660],
        ];
    }

    public function testAssertFilePermissionLink()
    {
        // make symlink if needed
        if (!file_exists($this->getAssetsDir().'test_link')) {
            symlink($this->getAssetsDir().'_link_test_target_dir_', $this->getAssetsDir().'test_link');
        }

        $this->assertFilePermissionMask(0664, $this->getAssetsDir().'test_link');
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
        return [
            [0007],
            [0005],
            [0055],
            [0777],
            [0005],
            [0050],
            [0764],
            [0700],
            [0704],
            [0650],
            [0764],
        ];
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory "/.*PHPUnit/tests/PHPUnit/Tests/Asserts" is empty.$#
     */
    public function testAssertDirectoryEmptyFail()
    {
        $this->assertDirectoryEmpty(__DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory "a/b/c/d" exists.$#
     */
    public function testAssertDirectoryExistsFail()
    {
        $this->assertDirectoryExists('a/b/c/d');
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file "/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php" exists as directory.$#
     */
    public function testAssertDirectoryExistsFile()
    {
        $this->assertDirectoryExists(__FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(NULL\#\) of FileSystemAssertTrait::assertDirectoryExists\(\) must be a string.$#
     */
    public function testAssertDirectoryExistsFailNull()
    {
        $this->assertDirectoryExists(null);
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file "/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php" is link.$#
     */
    public function testAssertFileIsLinkFailFile()
    {
        $this->assertFileIsLink(__FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory "/.*PHPUnit/tests/PHPUnit/Tests/Asserts" is link.$#
     */
    public function testAssertFileIsLinkFailDirectory()
    {
        $this->assertFileIsLink(__DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(integer\#678\) of FileSystemAssertTrait::assertFileIsLink\(\) must be a string.$#
     */
    public function testAssertFileIsLinkFailInteger()
    {
        $this->assertFileIsLink(678);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(NULL\#\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an integer \(>= 0\) or string.$#
     */
    public function testAssertFileHasPermissionsFailNull()
    {
        $this->assertFileHasPermissions(null, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(stdClass\#\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an integer \(>= 0\) or string.$#
     */
    public function testAssertFileHasPermissionsFailStdClass()
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
     * @expectedExceptionMessageRegExp #^Argument \#2 \(NULL\#\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be a string.$#
     */
    public function testAssertFileHasPermissionsFailFile()
    {
        $this->assertFileHasPermissions(0777, null);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that permission "100664" of file "/.*PHPUnit/tests/PHPUnit/Tests/Asserts/FileSystemAssertTraitTest.php" matches mask "777".$#
     */
    public function testAssertFilePermissionMaskFail()
    {
        $this->assertFilePermissionMask(0777, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that permission "40775" of directory "/.*PHPUnit/tests/PHPUnit/Tests/Asserts" does not match mask "755".$#
     */
    public function testAssertFilePermissionNotMaskFail()
    {
        $this->assertFilePermissionNotMask(0755, __DIR__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(NULL\#\) of FileSystemAssertTrait::assertFilePermissionMask\(\) must be an int.$#
     */
    public function testAssertFilePermissionMaskInvalidArg1()
    {
        $this->assertFilePermissionMask(null, __FILE__);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Argument \#2 \(integer\#89\) of FileSystemAssertTrait::assertFilePermissionMask\(\) must be a string.$#
     */
    public function testAssertFilePermissionMaskInvalidArg2()
    {
        $this->assertFilePermissionMask(0777, 89);
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that file "no_file" exists.$#
     */
    public function testAssertFilePermissionMaskInvalidArg2File()
    {
        $this->assertFilePermissionMask(0777, 'no_file');
    }

    public function testPermissionFormat()
    {
        $refection = new ReflectionClass($this);
        $refectionProperty = $refection->getProperty('permissionFormat');
        $refectionProperty->setAccessible(true);
        $permissionFormat = $refectionProperty->getValue($this);

        $this->assertRegExp($permissionFormat, 'lrwxrwxrwx');
        $this->assertRegExp($permissionFormat, '-rw-rw-r--');
        $this->assertRegExp($permissionFormat, 'drwxrwxr-x');
        $this->assertRegExp($permissionFormat, 'd--s--S--t');

        $this->assertNotRegExp($permissionFormat, ' d--s--S--t');
        $this->assertNotRegExp($permissionFormat, 'd--s--S--t ');
        $this->assertNotRegExp($permissionFormat, 'ad--s--S--t');
        $this->assertNotRegExp($permissionFormat, 'd--s--S--ta');

        $this->assertNotRegExp($permissionFormat, 'a');
        $this->assertNotRegExp($permissionFormat, 'd-');
        $this->assertNotRegExp($permissionFormat, '-rw-rw-r-');
        $this->assertNotRegExp($permissionFormat, 'lrwxawxrwx');
        $this->assertNotRegExp($permissionFormat, 'arwxrwxr-x');
        $this->assertNotRegExp($permissionFormat, '-rrrwwwxxx');
    }
}
