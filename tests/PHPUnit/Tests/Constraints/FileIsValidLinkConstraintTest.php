<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\FileIsValidLinkConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class FileIsValidLinkConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    public function testFileIsValidLinkToFile()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($link);
    }

    public function testFileIsValidLinkToDir()
    {
        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($link);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that link\#/.*tests/assets/invalid_link is a valid link.$#
     */
    public function testFileIsValidLinkToNowhere()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($this->getAssetsDir().'invalid_link');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is a valid link.$#
     */
    public function testFileIsValidLinkObject()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate(new \stdClass());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is a valid link.$#
     */
    public function testFileIsValidLinkNull()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate(null);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that string\#a is a valid link.$#
     */
    public function testFileIsValidLinkString()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate('a');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is a valid link.$#
     */
    public function testFileIsValidLinkNotString()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate(1);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*tests/assets/dir/test_file.txt is a valid link.$#
     */
    public function testFileIsValidLinkFile()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($this->getAssetsDir().'dir/test_file.txt');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*tests/assets/ is a valid link.$#
     */
    public function testFileIsValidLinkDir()
    {
        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($this->getAssetsDir());
    }
}
