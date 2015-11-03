<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

abstract class AbstractGeckoPHPUnitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return string
     */
    protected function getAssetsDir()
    {
        return __DIR__.'/../../assets/';
    }
}
