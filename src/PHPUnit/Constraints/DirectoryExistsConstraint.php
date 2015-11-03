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

final class DirectoryExistsConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        return is_dir($other);
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        if (is_file($other)) {
            return sprintf('file "%s" exists as directory', $other);
        }

        return sprintf('directory "%s" exists', $other);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'directory exists';
    }
}
