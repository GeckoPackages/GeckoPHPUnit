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

use GeckoPackages\PHPUnit\Constraints\DirectoryEmptyConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class DirectoryEmptyConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    public function testDirectoryEmptyConstraint()
    {
        $dir = $this->getAssetsDir().'emptyDirTest';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $constraint = new DirectoryEmptyConstraint();
        $this->assertTrue($constraint->evaluate($dir, '', true));

        @unlink($dir);
    }

    public function testDirectoryEmptyConstraintBasics()
    {
        $constraint = new DirectoryEmptyConstraint();
        $this->assertSame(1, $constraint->count());
        $this->assertSame('is an empty directory', $constraint->toString());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintDirWithFiles()
    {
        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate(__DIR__, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/DirectoryEmptyConstraintTest\.php is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintFile()
    {
        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate(__FILE__, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that link to file\#/.*test_link_file is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintFileLink()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate($link, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintInt()
    {
        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate(1, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintNull()
    {
        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate(null, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintObject()
    {
        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate(new \stdClass(), '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that __does_not_exists__ is an empty directory\.$#
     */
    public function testDirectoryEmptyConstraintString()
    {
        $constraint = new DirectoryEmptyConstraint();
        $constraint->evaluate('__does_not_exists__', '');
    }
}
