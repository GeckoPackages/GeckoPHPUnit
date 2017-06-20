<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

try {
    @chmod(__DIR__.'/assets/dir', 0755);
    @chmod(__DIR__.'/assets/dir/test_file.txt', 0644);
} catch (\Exception $e) {
}

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/PHPUnit/Tests/GeckoTestCase.php';
require_once __DIR__.'/PHPUnit/Tests/AbstractGeckoPHPUnitTest.php';
require_once __DIR__.'/PHPUnit/Tests/AbstractGeckoPHPUnitFileTest.php';
