<?php

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
abstract class AbstractGeckoPHPUnitFileTest extends AbstractGeckoPHPUnitTest
{
    /**
     * @param string $target filesystem path
     * @param string $link   filesystem path
     */
    protected function createSymlink($target, $link)
    {
        // File_exists returns false if the sym link exits but the target does not.
        // Therefor test if the symlink exists first and delete it if the target does not not.
        if (is_link($link) && !file_exists($link)) {
            unlink($link);
        }

        if (!file_exists($link) && false === @symlink($target, $link)) {
            $error = error_get_last();
            $this->fail(sprintf(
                'Failed to create symlink "%s" for target "%s"%s.',
                $link, $target, $error ? '. Error "'.$error['message'].'"' : ''
            ));
        }
    }
}
