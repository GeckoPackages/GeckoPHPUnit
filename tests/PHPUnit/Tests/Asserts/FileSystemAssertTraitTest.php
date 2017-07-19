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

use GeckoPackages\PHPUnit\Asserts\FileSystemAssertTrait;

/**
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

    /**
     * @param string|int $permission
     * @param string     $file
     *
     * @dataProvider provideFiles
     */
    public function testAssertFileHasPermissions($permission, string $file)
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFileHasPermissions($permission, $file);
    }

    public function provideFiles(): array
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        return [
            [0755, $this->getTestDir()],
            ['0'.$this->expectedDirPermissions, $this->getTestDir()],
            ['493', $this->getTestDir()],
            ['drwxr-xr-x', $this->getTestDir()],
            [0644, $this->getTestFile()],
            [100644, $this->getTestFile()],
            ['-rw-r--r--', $this->getTestFile()],
            ['lrwxrwxrwx', $link],
        ];
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*tests/assets/dir 0755 permissions are equal to 0644\.$#
     */
    public function testAssertFileHasPermissionsFailureDir()
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFileHasPermissions(0644, $this->getTestDir());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file\.txt 0644 permissions are equal to 0555\.$#
     */
    public function testAssertFileHasPermissionsFailureFile()
    {
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
    public function testAssertFilePermissionMask(int $mask)
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionMask($mask, $this->getTestFile());
    }

    public function provideFileMasks(): array
    {
        return [
            [0644],
            [0000],
            [0004],
            [0040],
            [0044],
            [0600],
            [0604],
            [0640],
        ];
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
    public function testAssertFilePermissionNotMask(int $mask)
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionNotMask($mask, $this->getTestFile());
    }

    public function provideFilePermissionNotMask(): array
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
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*tests/assets/dir is an empty directory\.$#
     */
    public function testAssertDirectoryEmptyFail()
    {
        $this->assertDirectoryEmpty($this->getTestDir());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file.txt is a link\.$#
     */
    public function testAssertFileIsLinkFailFile()
    {
        $this->assertFileIsLink($this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*tests/assets/dir is a link\.$#
     */
    public function testAssertFileIsLinkFailDirectory()
    {
        $this->assertFileIsLink($this->getTestDir());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#678 is a link\.$#
     */
    public function testAssertFileIsLinkFailInteger()
    {
        $this->assertFileIsLink(678);
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(null\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string\.$#
     */
    public function testAssertFileHasPermissionsFailNull()
    {
        $this->assertFileHasPermissions(null, $this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(stdClass\#\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string\.$#
     */
    public function testAssertFileHasPermissionsFailObject()
    {
        $this->assertFileHasPermissions(new \stdClass(), $this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(string\#invalidrwx\) of FileSystemAssertTrait::assertFileHasPermissions\(\) Permission to match "invalidrwx" is not formatted correctly\.$#
     */
    public function testAssertFileHasPermissionsFailInvalidPermissionString()
    {
        $this->assertFileHasPermissions('invalidrwx', $this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(integer\#-1\) of FileSystemAssertTrait::assertFileHasPermissions\(\) must be an int \(>= 0\) or string\.$#
     */
    public function testAssertFileHasPermissionsFailInvalidPermissionValue()
    {
        $this->assertFileHasPermissions(-1, $this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that null permissions are equal\.$#
     */
    public function testAssertFileHasPermissionsFailFile()
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFileHasPermissions(0777, null);
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file\.txt 100644 permissions matches mask 777\.$#
     */
    public function testAssertFilePermissionMaskFail()
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionMask(0777, $this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*tests/assets/dir 40755 permissions does not match mask 755\.$#
     */
    public function testAssertFilePermissionNotMaskFail()
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionNotMask(0755, $this->getTestDir());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Argument \#1 \(null\) of FileSystemAssertTrait::assertFilePermissionMask\(\) must be an int\.$#
     */
    public function testAssertFilePermissionMaskInvalidArg1()
    {
        $this->assertPermissionsFilesToTest();
        $this->assertFilePermissionMask(null, $this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#89 permissions matches mask\.$#
     */
    public function testAssertFilePermissionMaskInvalidArg2()
    {
        $this->assertFilePermissionMask(0777, 89);
    }

    /**
     * @expectedException PHPUnit\Framework\Exception
     * @expectedExceptionMessageRegExp #^Failed asserting that not file or directory\#no_file permissions matches mask\.$#
     */
    public function testAssertFilePermissionMaskInvalidArg2File()
    {
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
        $failures = [];
        $perm = fileperms($this->getTestDir());
        $perm = sprintf('%o', $perm);
        $perm = (int) substr($perm, -3);
        if ($this->expectedDirPermissions !== $perm) {
            $failures[$this->getTestDir()] = [$perm, $this->expectedDirPermissions];
        }

        $perm = fileperms($this->getTestFile());
        $perm = sprintf('%o', $perm);
        $perm = (int) substr($perm, -3);
        if (644 !== $perm) {
            $failures[$this->getTestFile()] = [$perm, $this->expectedFilePermissions];
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

    private function getTestDir(): string
    {
        return realpath($this->getAssetsDir().'/dir');
    }

    private function getTestFile(): string
    {
        return $this->getTestDir().'/test_file.txt';
    }
}
