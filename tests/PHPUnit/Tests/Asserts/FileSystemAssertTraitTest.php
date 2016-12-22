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
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class FileSystemAssertTraitTest extends AbstractGeckoPHPUnitFileTest
{
    use FileSystemAssertTrait;

    private $expectedDirPermissions = 755;
    private $expectedFilePermissions = 644;

    public function testAssertDirectoryEmpty()
    {
        $dir = $this->getAssetsDir().time();
        mkdir($dir);
        $this->assertDirectoryEmpty($dir);
        rmdir($dir);
        $this->assertDirectoryNotEmpty($this->getTestDir());
    }

    public function testAssertDirectoryExists()
    {
        $this->assertDirectoryExists($this->getTestDir());
        $this->assertDirectoryNotExists($this->getTestDir().'/no_such_dir/');
        $this->assertDirectoryNotExists($this->getTestFile());
    }

    /**
     * @param string $permission
     * @param string $file
     *
     * @dataProvider provideFiles
     */
    public function testAssertFileHasPermissions($permission, $file)
    {
        $this->assertPermissionsFilesToTest();
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
            array(0755, $this->getTestDir()),
            array('0'.$this->expectedDirPermissions, $this->getTestDir()),
            array('493', $this->getTestDir()),
            array('drwxr-xr-x', $this->getTestDir()),
            array(0644, $this->getTestFile()),
            array(100644, $this->getTestFile()),
            array('-rw-r--r--', $this->getTestFile()),
            array('lrwxrwxrwx', $link),
        );
    }

    public function testAssertFileHasPermissionsFailureDir()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*tests/assets/dir 0755 permissions are equal to 0644.$#');

        $this->assertPermissionsFilesToTest();
        $this->assertFileHasPermissions(0644, $this->getTestDir());
    }

    public function testAssertFileHasPermissionsFailureFile()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that file\#/.*tests/assets/dir/test_file.txt 0644 permissions are equal to 0555.$#');

        $this->assertPermissionsFilesToTest();
        $this->assertFileHasPermissions(0555, $this->getTestFile());
    }

    public function testAssertFileIsLink()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $this->assertFileIsLink($link);
        $this->assertFileIsNotLink($this->getTestFile());
    }

    /**
     * @param int $mask
     *
     * @dataProvider provideFileMasks
     */
    public function testAssertFilePermissionMask($mask)
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionMask($mask, $this->getTestFile());
    }

    public function provideFileMasks()
    {
        return array(
            array(0644),
            array(0000),
            array(0004),
            array(0040),
            array(0044),
            array(0600),
            array(0604),
            array(0640),
        );
    }

    public function testAssertFilePermissionLink()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $this->assertFilePermissionMask(0644, $link);
    }

    /**
     * @param int $mask
     *
     * @dataProvider provideFilePermissionNotMask
     */
    public function testAssertFilePermissionNotMask($mask)
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionNotMask($mask, $this->getTestFile());
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

    public function testAssertDirectoryEmptyFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*tests/assets/dir is an empty directory.$#');

        $this->assertDirectoryEmpty($this->getTestDir());
    }

    public function testAssertDirectoryExistsFail()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that a/b/c/d is a directory.$#');

        $this->assertDirectoryExists('a/b/c/d');
    }

    public function testAssertDirectoryExistsFile()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that file\#/.*tests/assets/dir/test_file.txt is a directory.$#');

        $this->assertDirectoryExists($this->getTestFile());
    }

    public function testAssertDirectoryExistsFailNull()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is a directory.$#');

        $this->assertDirectoryExists(null);
    }

    public function testAssertFileIsLinkFailFile()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that file\#/.*tests/assets/dir/test_file.txt is a link.$#');

        $this->assertFileIsLink($this->getTestFile());
    }

    public function testAssertFileIsLinkFailDirectory()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*tests/assets/dir is a link.$#');

        $this->assertFileIsLink($this->getTestDir());
    }

    public function testAssertFileIsLinkFailInteger()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#678 is a link.$#');

        $this->assertFileIsLink(678);
    }

    public function testAssertFileHasPermissionsFailNull()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#1 \(null\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string.$#');

        $this->assertFileHasPermissions(null, $this->getTestFile());
    }

    public function testAssertFileHasPermissionsFailObject()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#1 \(stdClass\#\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string.$#');

        $this->assertFileHasPermissions(new \stdClass(), $this->getTestFile());
    }

    public function testAssertFileHasPermissionsFailInvalidPermissionString()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^FileSystemAssertTrait::assertFileHasPermissions\(\) Permission to match "invalidrwx" is not formatted correctly.$#');

        $this->assertFileHasPermissions('invalidrwx', $this->getTestFile());
    }

    public function testAssertFileHasPermissionsFailInvalidPermissionValue()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#1 \(integer\#-1\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string.$#');

        $this->assertFileHasPermissions(-1, $this->getTestFile());
    }

    public function testAssertFileHasPermissionsFailFile()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null permissions are equal.$#');

        $this->assertPermissionsFilesToTest();
        $this->assertFileHasPermissions(0777, null);
    }

    public function testAssertFilePermissionMaskFail()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that file\#/.*tests/assets/dir/test_file.txt 100644 permissions matches mask 777.$#');

        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionMask(0777, $this->getTestFile());
    }

    public function testAssertFilePermissionNotMaskFail()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*tests/assets/dir 40755 permissions does not match mask 755.$#');

        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionNotMask(0755, $this->getTestDir());
    }

    public function testAssertFilePermissionMaskInvalidArg1()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Argument \#1 \(null\) of FileSystemAssertTrait::assertFilePermissionMask\(\) must be an int.$#');

        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionMask(null, $this->getTestFile());
    }

    public function testAssertFilePermissionMaskInvalidArg2()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#89 permissions matches mask.$#');

        $this->assertFilePermissionMask(0777, 89);
    }

    public function testAssertFilePermissionMaskInvalidArg2File()
    {
        $this->expectException(\PHPUnit_Framework_Exception::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that not file or directory\#no_file permissions matches mask.$#');

        $this->assertFilePermissionMask(0777, 'no_file');
    }

    /**
     * Assert file and directory used in tests have expected permissions.
     *
     * Testing with those without the right permissions causes false negatives,
     * including in environments like Travis.
     */
    private function assertPermissionsFilesToTest()
    {
        $failures = array();
        $perm = fileperms($this->getTestDir());
        $perm = sprintf('%o', $perm);
        $perm = (int) substr($perm, -3);
        if ($this->expectedDirPermissions !== $perm) {
            $failures[$this->getTestDir()] = array($perm, $this->expectedDirPermissions);
        }

        $perm = fileperms($this->getTestFile());
        $perm = sprintf('%o', $perm);
        $perm = (int) substr($perm, -3);
        if (644 !== $perm) {
            $failures[$this->getTestFile()] = array($perm, $this->expectedFilePermissions);
        }

        if (count($failures)) {
            $message = '';
            foreach ($failures as $item => $fail) {
                $message .= sprintf(
                    "\nFailed test resource \"%s\" has permissions \"%d\", expected \"%d\".",
                    $item, $fail[0], $fail[1]
                );
            }

            throw new \RuntimeException($message);
        }
    }

    private function getTestDir()
    {
        return realpath($this->getAssetsDir().'/dir');
    }

    private function getTestFile()
    {
        return $this->getTestDir().'/test_file.txt';
    }
}
