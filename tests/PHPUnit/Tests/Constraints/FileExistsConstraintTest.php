<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\FileExistsConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class FileExistsConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    /**
     * @param string $file
     *
     * @dataProvider provideFiles
     */
    public function testFileExistsConstraint($file)
    {
        $constraint = new FileExistsConstraint();
        $this->assertTrue($constraint->evaluate($file, '', true));
    }

    public function provideFiles()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        return array(
            array(__FILE__),
            array($link),
        );
    }

    public function testFileExistsConstraintBasics()
    {
        $constraint = new FileExistsConstraint();
        $this->assertSame(1, $constraint->count());
        $this->assertSame('is a file', $constraint->toString());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints is a file\.$#
     */
    public function testFileExistsConstraintDir()
    {
        $constraint = new FileExistsConstraint();
        $constraint->evaluate(__DIR__, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that link to directory\#/.*test_link_dir is a file\.$#
     */
    public function testFileExistsConstraintFileLink()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $constraint = new FileExistsConstraint();
        $constraint->evaluate($link, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is a file\.$#
     */
    public function testFileExistsConstraintInt()
    {
        $constraint = new FileExistsConstraint();
        $constraint->evaluate(1, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is a file\.$#
     */
    public function testFileExistsConstraintNull()
    {
        $constraint = new FileExistsConstraint();
        $constraint->evaluate(null, '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is a file\.$#
     */
    public function testFileExistsConstraintObject()
    {
        $constraint = new FileExistsConstraint();
        $constraint->evaluate(new \stdClass(), '');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that __does_not_exists__ is a file\.$#
     */
    public function testFileExistsConstraintString()
    {
        $constraint = new FileExistsConstraint();
        $constraint->evaluate('__does_not_exists__', '');
    }
}
