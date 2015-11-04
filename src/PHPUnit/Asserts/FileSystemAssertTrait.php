<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GeckoPackages\PHPUnit\Asserts;

use GeckoPackages\PHPUnit\Constraints\DirectoryEmptyConstraint;
use GeckoPackages\PHPUnit\Constraints\DirectoryExistsConstraint;
use GeckoPackages\PHPUnit\Constraints\IsFileLinkConstraint;
use GeckoPackages\PHPUnit\Constraints\PermissionIsIdenticalConstraint;
use GeckoPackages\PHPUnit\Constraints\PermissionMaskConstraint;

/**
 * Provides asserts for testing directories, files and symbolic links.
 *
 * Additional PHPUnit asserts for testing file (system) based logic.
 *
 * @requires PHPUnit >= 3.0.0 (https://phpunit.de/)
 *
 * @note Some code is derived from the example on PHP net (http://php.net/manual/en/function.fileperms.php)
 *
 * @api
 *
 * @author SpacePossum
 */
trait FileSystemAssertTrait
{
    private static $permissionFormat = '#^[slbdcpu\-]([r-][w-][sxS-]){2}[r-][w-][txT-]$#';

    /**
     * Assert that a directory exists and is empty.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertDirectoryEmpty($filename, $message = '')
    {
        self::assertDirectory($filename, $message, 'assertDirectoryEmpty', new DirectoryExistsConstraint());
        self::assertThat($filename, new DirectoryEmptyConstraint(), $message);
    }

    /**
     * Assert that a directory exists and is not empty.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertDirectoryNotEmpty($filename, $message = '')
    {
        self::assertDirectory($filename, $message, 'assertDirectoryNotEmpty', new DirectoryExistsConstraint());
        self::assertThat($filename, new \PHPUnit_Framework_Constraint_Not(new DirectoryEmptyConstraint()), $message);
    }

    /**
     * Assert that a directory exists.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertDirectoryExists($filename, $message = '')
    {
        self::assertDirectory($filename, $message, 'assertDirectoryExists', new DirectoryExistsConstraint());
    }

    /**
     * Assert that a filename does not exists as directory.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertDirectoryNotExists($filename, $message = '')
    {
        self::assertDirectory($filename, $message, 'assertDirectoryNotExists', new \PHPUnit_Framework_Constraint_Not(new DirectoryExistsConstraint()));
    }

    /**
     * Asserts that a file permission matches, for example: 'drwxrwxrwx' or '0664'.
     *
     * @param int|string $permissions > 0 or string; format for example: 'drwxrwxrwx'.
     * @param string     $filename
     * @param string     $message
     */
    public static function assertFileHasPermissions($permissions, $filename, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertFileHasPermissions', array('assertThat', 'assertFileExists'));

        if (!is_string($filename)) {
            throw AssertHelper::createArgumentException(__TRAIT__, 'assertFileHasPermissions', 'string', $filename, 2);
        }
        self::assertFileExists($filename, $message);

        if (is_link($filename)) {
            $perms = lstat($filename)['mode'];
            $type = 'link';
        } else {
            $perms = fileperms($filename);
            $type = is_file($filename) ? 'file' : (is_dir($filename) ? 'directory' : 'other');
        }

        if (is_string($permissions)) {
            if (!ctype_digit($permissions)) {
                if (1 !== preg_match(self::$permissionFormat, $permissions)) {
                    throw AssertHelper::createException(__TRAIT__, 'assertFileHasPermissions', sprintf('Permission to match "%s" is not formatted correctly', $permissions));
                }

                self::assertThat(self::getFilePermissionsAsString($perms), new PermissionIsIdenticalConstraint($permissions, $filename, $type), $message);

                return;
            }

            if ('0' === $permissions[0]) {
                $permissions = intval($permissions, 8);
            } else {
                $permissions = (int) $permissions;
            }
        }

        if (!is_int($permissions) || $permissions < 0) {
            throw AssertHelper::createArgumentException(__TRAIT__, 'assertFileHasPermissions', 'integer (>= 0) or string', $permissions);
        }

        // for example 0777 vs 100777
        if ($permissions < 1412) {
            $permissions = (int) sprintf('%o', $permissions);
            $filePerm = (int) substr(sprintf('%o', $perms), -3);
        } else {
            $filePerm = (int) sprintf('%o', $perms);
        }

        self::assertThat($filePerm, new PermissionIsIdenticalConstraint($permissions, $filename, $type), $message);
    }

    /**
     * Assert that a file is a symbolic link.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertFileIsLink($filename, $message = '')
    {
        self::assertFileLInk($filename, $message, 'assertFileIsLink', new IsFileLinkConstraint());
    }

    /**
     * Assert that a file is not a symbolic link.
     *
     * @param string $filename
     * @param string $message
     */
    public static function assertFileIsNotLink($filename, $message = '')
    {
        self::assertFileLInk($filename, $message, 'assertFileIsNotLink', new \PHPUnit_Framework_Constraint_Not(new IsFileLinkConstraint()));
    }

    /**
     * Asserts that a file permission matches mask, for example: '0007'.
     *
     * @param int    $permissionMask
     * @param string $filename
     * @param string $message
     */
    public static function assertFilePermissionMask($permissionMask, $filename, $message = '')
    {
        self::filePermissionMask($permissionMask, $filename, 'assertFilePermissionMask', true, $message);
    }

    /**
     * Asserts that a file permission does not matches mask, for example: '0607'.
     *
     * @param int    $permissionMask
     * @param string $filename
     * @param string $message
     */
    public static function assertFilePermissionNotMask($permissionMask, $filename, $message = '')
    {
        self::filePermissionMask($permissionMask, $filename, 'assertFilePermissionNotMask', false, $message);
    }

    private static function filePermissionMask($permissionMask, $filename, $method, $positive, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, array('assertThat', 'assertFileExists'));

        if (!is_int($permissionMask)) {
            throw AssertHelper::createArgumentException(__TRAIT__, $method, 'int', $permissionMask);
        }

        if (!is_string($filename)) {
            throw AssertHelper::createArgumentException(__TRAIT__, $method, 'string', $filename, 2);
        }
        self::assertFileExists($filename, $message);

        if (is_link($filename)) {
            $perms = lstat($filename)['mode'];
            $type = 'link';
        } else {
            $perms = fileperms($filename);
            $type = is_file($filename) ? 'file' : (is_dir($filename) ? 'directory' : 'other');
        }

        $constraint = new PermissionMaskConstraint($permissionMask, $filename, $type);

        self::assertThat($perms, $positive ? $constraint : new \PHPUnit_Framework_Constraint_Not($constraint), $message);
    }

    private static function assertDirectory($filename, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, array('assertThat'));

        if (!is_string($filename)) {
            throw AssertHelper::createArgumentException(__TRAIT__, $method, 'string', $filename);
        }

        self::assertThat($filename, $constraint, $message);
    }

    private static function assertFileLInk($filename, $message, $method, \PHPUnit_Framework_Constraint $constraint)
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, $method, array('assertThat', 'assertFileExists'));

        if (!is_string($filename)) {
            throw AssertHelper::createArgumentException(__TRAIT__, $method, 'string', $filename);
        }

        self::assertFileExists($filename, $message);
        self::assertThat($filename, $constraint, $message);
    }

    /**
     * @param int $perms
     *
     * @return string
     */
    private static function getFilePermissionsAsString($perms)
    {
        if (($perms & 0xC000) === 0xC000) {       // Socket
            $info = 's';
        } elseif (($perms & 0xA000) === 0xA000) { // Symbolic Link
            $info = 'l';
        } elseif (($perms & 0x8000) === 0x8000) { // Regular
            $info = '-';
        } elseif (($perms & 0x6000) === 0x6000) { // Block special
            $info = 'b';
        } elseif (($perms & 0x4000) === 0x4000) { // Directory
            $info = 'd';
        } elseif (($perms & 0x2000) === 0x2000) { // Character special
            $info = 'c';
        } elseif (($perms & 0x1000) === 0x1000) { // FIFO pipe
            $info = 'p';
        } else { // Unknown
            $info = 'u';
        }

        // Owner
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x') :
            (($perms & 0x0800) ? 'S' : '-'));

        // Group
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x') :
            (($perms & 0x0400) ? 'S' : '-'));

        // World
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x') :
            (($perms & 0x0200) ? 'T' : '-'));

        return $info;
    }
}
