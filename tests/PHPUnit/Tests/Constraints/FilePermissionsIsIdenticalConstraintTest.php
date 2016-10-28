<?php

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
    public function testFilePermissionsMaskConstraint($expected, $permission)
    {
        $constraint = new FilePermissionsIsIdenticalConstraint($permission);
        $this->assertSame($expected, $constraint->evaluate(__FILE__, '', true));
    }

    public function providePermissionExpected()
    {
        return array(
            array(true, 100664),
            array(true, '100664'),
            array(true, '0664'),
            array(true, '-rw-rw-r--'),
        );
    }

    public function testFilePermissionsMaskConstraintBasic()
    {
        $constraint = new FilePermissionsIsIdenticalConstraint(1);
        $this->assertSame(1, $constraint->count());
        $this->assertSame('permissions are equal', $constraint->toString());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"-1\", expected >= 0.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg1()
    {
        new FilePermissionsIsIdenticalConstraint(-1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Permission to match \"invalid"\ is not formatted correctly.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg2()
    {
        new FilePermissionsIsIdenticalConstraint('invalid');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"stdClass\#\", expected int >= 0 or string.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg3()
    {
        $c = new FilePermissionsIsIdenticalConstraint(new \stdClass());
        $c->evaluate(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"null\", expected int >= 0 or string.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg4()
    {
        $c = new FilePermissionsIsIdenticalConstraint(null);
        $c->evaluate(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Invalid value for permission to match \"double\#1.5\", expected int >= 0 or string.$#
     */
    public function testFilePermissionsMaskConstraintInvalidArg5()
    {
        $c = new FilePermissionsIsIdenticalConstraint(1.5);
        $c->evaluate(1);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null permissions are equal.$#
     */
    public function testFilePermissionsMaskConstraintNull()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate(null);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 permissions are equal.$#
     */
    public function testFilePermissionsMaskConstraintInt()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate(1);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# permissions are equal.$#
     */
    public function testFilePermissionsMaskConstraintObject()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate(new \stdClass());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that not file or directory\#_does_not_exists_ permissions are equal.$#
     */
    public function testFilePermissionsMaskConstraintNoFile()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate('_does_not_exists_');
    }

    public function testFilePermissionsMaskConstraintFileLink()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $c = new FilePermissionsIsIdenticalConstraint(0777);
        $c->evaluate($link);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that link\#/.*PHPUnit/tests/assets/test_link_file 0777 permissions are equal to 0111.$#
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
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/FilePermissionsIsIdenticalConstraintTest.php 0664 permissions are equal to 0111.$#
     */
    public function testFilePermissionsMaskConstraintFileMismatch()
    {
        $c = new FilePermissionsIsIdenticalConstraint(0111);
        $c->evaluate(__FILE__);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/FilePermissionsIsIdenticalConstraintTest.php 0100664 permissions are equal to 0100775.$#
     */
    public function testFilePermissionsMaskConstraintFileMismatchLarge()
    {
        $c = new FilePermissionsIsIdenticalConstraint(100775);
        $c->evaluate(__FILE__);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/FilePermissionsIsIdenticalConstraintTest.php -rw-rw-r-- permissions are equal to -rw-rw-rw-.$#
     */
    public function testFilePermissionsMaskConstraintFileMismatchString()
    {
        $c = new FilePermissionsIsIdenticalConstraint('-rw-rw-rw-');
        $c->evaluate(__FILE__);
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
     * @param string $input
     *
     * @dataProvider provideFilePermissions
     */
    public function testGetFilePermissionsAsString($expected, $input)
    {
        $reflection = new \ReflectionClass('GeckoPackages\PHPUnit\Constraints\FilePermissionsIsIdenticalConstraint');
        $method = $reflection->getMethod('getFilePermissionsAsString');
        $method->setAccessible(true);
        $this->assertSame($expected, $method->invokeArgs($this, array($input)));
    }

    public function provideFilePermissions()
    {
        return array(
            array('drwxrwxr-x', fileperms(__DIR__)),
            array('urwxrwxrwx', 0777),
            array('prwxrwxrwx', 010777),
            array('crwxrwxrwx', 020777),
            array('brwxrwxrwx', 060777),
            array('srwxrwxrwx', 0140777),
        );
    }
}
