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

use GeckoPackages\PHPUnit\Constraints\FileIsLinkConstraint;

/**
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
    public function testFileIsLinkConstraint(string $link)
    {
        $constraint = new FileIsLinkConstraint();
        $this->assertTrue($constraint->evaluate($link, '', true));
    }

    public function provideLinks(): array
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

        return [
            [$link],
            [$dirLink],
        ];
    }

    public function testFileIsLinkConstraintBasics()
    {
        $constraint = new FileIsLinkConstraint();
        $this->assertSame(1, $constraint->count());
        $this->assertSame('is a link', $constraint->toString());
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that directory\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints is a link\.$#
     */
    public function testFileIsLinkConstraintDir()
    {
        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(__DIR__, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that file\#/.*PHPUnit/tests/PHPUnit/Tests/Constraints/FileIsLinkConstraintTest.php is a link\.$#
     */
    public function testFileIsLinkConstraintFile()
    {
        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(__FILE__, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that integer\#1 is a link\.$#
     */
    public function testFileIsLinkConstraintInt()
    {
        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(1, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that null is a link\.$#
     */
    public function testFileIsLinkConstraintNull()
    {
        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(null, '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that stdClass\# is a link\.$#
     */
    public function testFileIsLinkConstraintObject()
    {
        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate(new \stdClass(), '');
    }

    /**
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessageRegExp #^Failed asserting that __does_not_exists__ is a link\.$#
     */
    public function testFileIsLinkConstraintString()
    {
        $constraint = new FileIsLinkConstraint();
        $constraint->evaluate('__does_not_exists__', '');
    }
}
