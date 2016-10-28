<?php

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
    public function testFilePermissionsMaskConstraint($mask)
    {
        $constraint = new FilePermissionsMaskConstraint($mask);
        $this->assertTrue($constraint->evaluate(__FILE__, '', true));
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

    public function testFilePermissionsMaskConstraintBasic()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $this->assertSame(1, $constraint->count());
        $this->assertSame('permissions matches mask', $constraint->toString());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that boolean\# permissions matches mask.$#
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
        $constraint->evaluate($link);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that not file or directory\#_does_not_exists_ permissions matches mask.$#
     */
    public function testFilePermissionsMaskConstraintFileNotExists()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate('_does_not_exists_');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1443 permissions matches mask.$#
     */
    public function testFilePermissionsMaskConstraintInt()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(1443);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/FilePermissionsMaskConstraintTest.php 100664 permissions matches mask 777.$#
     */
    public function testFilePermissionsMaskConstraintMaskMismatch()
    {
        $constraint = new FilePermissionsMaskConstraint(0777);
        $constraint->evaluate(__FILE__);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null permissions matches mask.$#
     */
    public function testFilePermissionsMaskConstraintNull()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(null);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# permissions matches mask.$#
     */
    public function testFilePermissionsMaskConstraintObject()
    {
        $constraint = new FilePermissionsMaskConstraint(1);
        $constraint->evaluate(new \stdClass());
    }
}
