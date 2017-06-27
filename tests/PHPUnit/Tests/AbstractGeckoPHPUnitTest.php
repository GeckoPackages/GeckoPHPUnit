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

/**
 * @internal
 *
 * @author SpacePossum
 */
abstract class AbstractGeckoPHPUnitTest extends GeckoTestCase
{
    /**
     * @return string
     */
    protected function getAssetsDir(): string
    {
        static $assertDir;

        if (null === $assertDir) {
            $assertDir = realpath(__DIR__.'/../../assets').'/';
        }

        return $assertDir;
    }
}
