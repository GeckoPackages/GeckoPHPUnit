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
 * @requires PHPUnit 5.2
 *
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

    public function testFileIsValidLinkToNowhere()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that link\#/.*tests/assets/invalid_link is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($this->getAssetsDir().'invalid_link');
    }

    public function testFileIsValidLinkObject()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate(new \stdClass());
    }

    public function testFileIsValidLinkNull()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate(null);
    }

    public function testFileIsValidLinkString()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that string\#a is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate('a');
    }

    public function testFileIsValidLinkNotString()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1 is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate(1);
    }

    public function testFileIsValidLinkFile()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that file\#/.*tests/assets/dir/test_file.txt is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($this->getAssetsDir().'dir/test_file.txt');
    }

    public function testFileIsValidLinkDir()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*tests/assets/ is a valid link.$#');

        $constraint = new FileIsValidLinkConstraint();
        $constraint->evaluate($this->getAssetsDir());
    }
}
