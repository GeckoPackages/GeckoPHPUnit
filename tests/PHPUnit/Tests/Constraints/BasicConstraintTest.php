<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use GeckoPackages\PHPUnit\Constraints\FilePermissionsIsIdenticalConstraint;
use GeckoPackages\PHPUnit\Constraints\ScalarConstraint;

/**
 * @internal
 *
 * @author SpacePossum
 */
final class BasicConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $class
     *
     * @dataProvider provideClasses
     */
    public function testToString($class)
    {
        if (false !== strpos($class, 'Abstract')) {
            return;
        }

        /** @var PHPUnit_Framework_Constraint $constraint */
        $constraint = new $class(1, 2, 3);
        $constraint->toString();
    }

    public function provideClasses()
    {
        $classes = array();
        $classDir = __DIR__.'/../../../../src/PHPUnit/Constraints';
        $namespace = 'GeckoPackages\\PHPUnit\\Constraints\\';
        foreach (new DirectoryIterator($classDir) as $file) {
            if ($file->isDot()) {
                continue;
            }

            if ($file->isDir() && 'XML' === $file->getFilename()) {
                foreach (new DirectoryIterator($file->getRealPath()) as $xmlFile) {
                    if ($xmlFile->isDir()) {
                        continue;
                    }
                    $classes[] = array($namespace.'XML\\'.substr($xmlFile->getFilename(), 0, -4));
                }

                continue;
            }
            $classes[] = array($namespace.substr($file->getFilename(), 0, -4));
        }

        return $classes;
    }

    public function testPermissionIsIdenticalConstraint()
    {
        $constraint = new FilePermissionsIsIdenticalConstraint('abc', __FILE__, 'a');
        $this->assertSame('is identical to permission "abc"', $constraint->toString());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp #^Unknown ScalarConstraint type "-1" provided.$#
     */
    public function testScalarConstraintConstructorInvalidTyp()
    {
        new ScalarConstraint(-1);
    }
}
