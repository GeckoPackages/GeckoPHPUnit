<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\FileIsLinkConstraint;

/**
 * @requires PHPUnit 5.2
 *
 * @internal
 *
 * @author SpacePossum
 */
final class FileIsLinkConstraintTest extends AbstractGeckoPHPUnitFileTest
{
    /**
     * @param string $link
     *
     * @dataProvider provideLinks
     */
    public function testFileIsLinkConstraint($link)
    {
        $constraint = new FileIsLinkConstraint();
        $this->assertTrue($constraint->evaluate($link, '', true));
    }

    public function provideLinks()
    {
        $link = $this->getAssetsDir().'test_link_file';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_/placeholder.tmp',
            $link
        );

        $dirLink = $this->getAssetsDir().'test_link_dir';
        $this->createSymlink(
            $this->getAssetsDir().'_link_test_target_dir_',
            $dirLink
        );

        return array(
            array($link),
            array($dirLink),
        );
    }

    public function testFileIsLinkConstraintBasics()
    {
        $constraint = new FileIsLinkConstraint();
        $this->assertSame(1, $constraint->count());
        $this->assertSame('is a link', $constraint->toString());
    }

    public function testFileIsLinkConstraintDir()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints is a link.$#');

        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(__DIR__, '');
    }

    public function testFileIsLinkConstraintFile()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/FileIsLinkConstraintTest.php is a link.$#');

        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(__FILE__, '');
    }

    public function testFileIsLinkConstraintInt()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that integer\#1 is a link.$#');

        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(1, '');
    }

    public function testFileIsLinkConstraintNull()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that null is a link.$#');

        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(null, '');
    }

    public function testFileIsLinkConstraintObject()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that stdClass\# is a link.$#');

        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(new \stdClass(), '');
    }

    public function testFileIsLinkConstraintString()
    {
        $this->expectException(\PHPUnit_Framework_ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp('#^Failed asserting that __does_not_exists__ is a link.$#');

        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate('__does_not_exists__', '');
    }
}
