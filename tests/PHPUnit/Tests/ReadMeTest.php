<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class ReadMeTest extends PHPUnit_Framework_TestCase
{
    public function testReadMe()
    {
        $this->assertStringEqualsFile(__DIR__.'/../../../README.md', $this->generateReadMe());
    }

    public function generateReadMe()
    {
        require_once __DIR__.'/ReadMeGenerator.php';
        $generator = new ReadMeGenerator();

        return $generator->generateReadMe($this->getClasses());
    }

    /**
     * @return string[]
     */
    private function getClasses()
    {
        $classDir = new ReflectionClass('GeckoPackages\PHPUnit\Asserts\AssertHelper');
        $classDir = $classDir->getFileName();
        $classDir = substr($classDir, 0, strrpos($classDir, '/'));
        $classes = [];
        foreach (new DirectoryIterator($classDir) as $file) {
            if ($file->isDir()) {
                continue;
            }
            $classes[] = 'GeckoPackages\\PHPUnit\\Asserts\\'.substr($file->getFilename(), 0, -4);
        }

        sort($classes);

        return $classes;
    }
}
