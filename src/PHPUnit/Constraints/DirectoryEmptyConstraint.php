<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GeckoPackages\PHPUnit\Constraints;

/**
 * @author SpacePossum
 */
final class DirectoryEmptyConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        foreach (new \DirectoryIterator($other) as $file) {
            if ($file->isDot()) {
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        return sprintf('directory "%s" is empty', $other);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'directory is empty';
    }
}
