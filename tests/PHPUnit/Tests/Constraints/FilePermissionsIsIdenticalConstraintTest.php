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

use GeckoPackages\PHPUnit\Constraints\FilePermissionsIsIdenticalConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class FilePermissionsIsIdenticalConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    /**
     * @param bool       $expected
     * @param int|string $permission
     *
     * @dataProvider providePermissionExpected
     */
    public function testFilePermissionsMaskConstraint(bool $expected, $permission)
    {
        $constraint = new FilePermissionsIsIdenticalConstraint($permission);
        $this->assertSame($expected, $constraint->evaluate($this->getTestFile(), '', true));
    }

    public function providePermissionExpected(): array
    {
        return [
            [true, 100644],
            [true, '100644'],
            [true, '0644'],
            [true, '-rw-r--r--'],
        ];
    }

    public function testFilePermissionsMaskConstraintBasic()
    {
        $constraint = new FilePermissionsIsIdenticalConstraint(1);
        $this->assertSame(1, $constraint->count());
        $this->assertSame('permissions are equal', $constraint->toString());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"-1\", expected >= 0\.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg1()
    {
        new FilePermissionsIsIdenticalConstraint(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Permission to match \"invalid"\ is not formatted correctly\.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg2()
    {
        new FilePermissionsIsIdenticalConstraint('invalid');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"stdClass\#\", expected int >= 0 or string\.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg3()
    {
        $c = new FilePermissionsIsIdenticalConstraint(new \stdClass());
        $c->evaluate(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"null\", expected int >= 0 or string\.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg4()
    {
        $c = new FilePermissionsIsIdenticalConstraint(null);
        $c->evaluate(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"double\#1.5\", expected int >= 0 or string\.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg5()
    {
        $c = new FilePermissionsIsIdenticalConstraint(1.5);
        $c->evaluate(1);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 permissions are equal\.$#
     */
    public function testFilePermissionsMaskConstraintInt()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate(1);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that not file or directory\#_does_not_exists_ permissions are equal\.$#
     */
    public function testFilePermissionsMaskConstraintNoFile()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate('_does_not_exists_');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null permissions are equal\.$#
     */
    public function testFilePermissionsMaskConstraintNull()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate(null);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# permissions are equal\.$#
     */
    public function testFilePermissionsMaskConstraintObject()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate(new \stdClass());
    }

    public function testFilePermissionsMaskConstraintFileLink()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $this->assertTrue($c->evaluate($link, '', true));
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that link\#/.*PHPUnit/tests/assets/test_link_file 0777 permissions are equal to 0111\.$#
     */
    public function testFilePermissionsMaskConstraintFileLinkMismatch()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $c = new FilePermissionsIsIdenticalConstraint(0111);
        $c->evaluate($link);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file\.txt 0644 permissions are equal to 0111\.$#
     */
    public function testFilePermissionsMaskConstraintFileMismatch()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0111);
        $c->evaluate($this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file\.txt 0100644 permissions are equal to 0100775\.$#
     */
    public function testFilePermissionsMaskConstraintFileMismatchLarge()
    {
        $c = new FilePermissionsIsIdenticalConstraint(100775);
        $c->evaluate($this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file\.txt -rw-r--r-- permissions are equal to -rw-rw-rw-\.$#
     */
    public function testFilePermissionsMaskConstraintFileMismatchString()
    {
        $c = new FilePermissionsIsIdenticalConstraint('-rw-rw-rw-');
        $c->evaluate($this->getTestFile());
    }

    public function testPermissionFormat()
    {
        $refection = new ReflectionClass('GeckoPackages\PHPUnit\Constraints\FilePermissionsIsIdenticalConstraint');
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

    /**
     * @param string $expected
     * @param int    $input
     *
     * @dataProvider provideFilePermissions
     */
    public function testPermissionsGetAsString(string $expected, int $input)
    {
        $reflection = new \ReflectionClass('GeckoPackages\PHPUnit\Constraints\FilePermissionsIsIdenticalConstraint');
        $method = $reflection->getMethod('getFilePermissionsAsString');
        $method->setAccessible(true);
        $this->assertSame($expected, $method->invokeArgs($this, [$input]));
    }

    public function provideFilePermissions(): array
    {
        return [
            ['drwxr-xr-x', fileperms($this->getAssetsDir().'/dir')], // 7775
            ['urwxrwxrwx', 0777],
            ['prwxrwxrwx', 010777],
            ['crwxrwxrwx', 020777],
            ['brwxrwxrwx', 060777],
            ['srwxrwxrwx', 0140777],
        ];
    }

    private function getTestFile(): string
    {
        return realpath($this->getAssetsDir().'/dir/test_file.txt');
    }
}
