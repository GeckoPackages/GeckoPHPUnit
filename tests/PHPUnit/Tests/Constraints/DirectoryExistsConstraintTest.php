<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\DirectoryExistsConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class DirectoryExistsConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    /**
     * @param string $dir
     *
     * @dataProvider provideDirectories
     */
    public function testDirectoryExistsConstraint($dir)
    {
        $constraint = new DirectoryExistsConstraint();
        $this->assertTrue($constraint->evaluate($dir, '', true));
    }

    public function provideDirectories()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        return array(
            array(__DIR__),
            array($link),
        );
    }

    public function testDirectoryExistsConstraintBasics()
    {
        $constraint = new DirectoryExistsConstraint();
        $this->assertSame(1, $constraint->count());
        $this->assertSame('is a directory', $constraint->toString());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/DirectoryExistsConstraintTest.php is a directory.$#
     */
    public function testDirectoryExistsConstraintFile()
    {
        $constraint = new DirectoryExistsConstraint();
        $constraint->evaluate(__FILE__, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that link to file\#/.*test_link_file is a directory.$#
     */
    public function testDirectoryExistsConstraintFileLink()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $constraint = new DirectoryExistsConstraint();
        $constraint->evaluate($link, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is a directory.$#
     */
    public function testDirectoryExistsConstraintInt()
    {
        $constraint = new DirectoryExistsConstraint();
        $constraint->evaluate(1, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is a directory.$#
     */
    public function testDirectoryExistsConstraintNull()
    {
        $constraint = new DirectoryExistsConstraint();
        $constraint->evaluate(null, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is a directory.$#
     */
    public function testDirectoryExistsConstraintObject()
    {
        $constraint = new DirectoryExistsConstraint();
        $constraint->evaluate(new \stdClass(), '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that __does_not_exists__ is a directory.$#
     */
    public function testDirectoryExistsConstraintString()
    {
        $constraint = new DirectoryExistsConstraint();
        $constraint->evaluate('__does_not_exists__', '');
    }
}
