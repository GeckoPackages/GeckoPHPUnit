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

final class IsFileLinkConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        return is_link($other);
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        if (is_file($other)) {
            $type = 'file';
        } elseif (is_dir($other)) {
            $type = 'directory';
        } else {
            $type = gettype($other);
        }

        return sprintf('%s "%s" is link', $type, $other);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'file is link';
    }
}
