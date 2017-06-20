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

use GeckoPackages\PHPUnit\Constraints\FilePermissionsMaskConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class FilePermissionsMaskConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    /**
     * @param int $mask
     *
     * @dataProvider provideFileMasks
     */
    public function testFilePermissionsMaskConstraint(int $mask)
    {
        $constraint = new FilePermissionsMaskConstraint($mask);
        $this->assertTrue($constraint->evaluate($this->getTestFile(), '', true));
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

    public function testFilePermissionsMaskConstraintBasic()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $this->assertSame(1, $constraint->count());
        $this->assertSame('permissions matches mask', $constraint->toString());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that boolean\# permissions matches mask\.$#
     */
    public function testFilePermissionsMaskConstraintFalse()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(false);
    }

    public function testFilePermissionsMaskConstraintFileLink()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $constraint = new FilePermissionsMaskConstraint(0xA000);
        $this->assertTrue($constraint->evaluate($link, '', true));
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that not file or directory\#_does_not_exists_ permissions matches mask\.$#
     */
    public function testFilePermissionsMaskConstraintFileNotExists()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate('_does_not_exists_');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1443 permissions matches mask\.$#
     */
    public function testFilePermissionsMaskConstraintInt()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(1443);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file.txt 100644 permissions matches mask 777\.$#
     */
    public function testFilePermissionsMaskConstraintMaskMismatch()
    {
        $constraint = new FilePermissionsMaskConstraint(0777);
        $constraint->evaluate($this->getTestFile());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null permissions matches mask\.$#
     */
    public function testFilePermissionsMaskConstraintNull()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(null);
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# permissions matches mask\.$#
     */
    public function testFilePermissionsMaskConstraintObject()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(new \stdClass());
    }

    private function getTestFile(): string
    {
        return realpath($this->getAssetsDir().'/dir/test_file.txt');
    }
}
