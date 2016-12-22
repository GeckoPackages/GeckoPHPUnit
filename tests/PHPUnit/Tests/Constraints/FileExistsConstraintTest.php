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
 * @requires PHPUnit 5.2
 *
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

    public function testFileExistsConstraintDir()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints is a file.$#');

        $constraint = new FileExistsConstraint();
        $constraint->evaluate(__DIR__, '');
    }

    public function testFileExistsConstraintFileLink()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that link to directory\#/.*test_link_dir is a file.$#');

        $link = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $link
        );

        $constraint = new FileExistsConstraint();
        $constraint->evaluate($link, '');
    }

    public function testFileExistsConstraintInt()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1 is a file.$#');

        $constraint = new FileExistsConstraint();
        $constraint->evaluate(1, '');
    }

    public function testFileExistsConstraintNull()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is a file.$#');

        $constraint = new FileExistsConstraint();
        $constraint->evaluate(null, '');
    }

    public function testFileExistsConstraintObject()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# is a file.$#');

        $constraint = new FileExistsConstraint();
        $constraint->evaluate(new \stdClass(), '');
    }

    public function testFileExistsConstraintString()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that __does_not_exists__ is a file.$#');

        $constraint = new FileExistsConstraint();
        $constraint->evaluate('__does_not_exists__', '');
    }
}
