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
final class FileExistsConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        return is_file($other);
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        if (is_dir($other)) {
            return sprintf('directory "%s" exists as file', $other);
        }

        return sprintf('file "%s" exists', $other);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'file exists';
    }
}
