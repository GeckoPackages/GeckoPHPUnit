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
 * @api
 *
 * @author SpacePossum
 */
final class UnsignedIntConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'is unsigned int';
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        return is_int($other) && $other >= 0;
    }
}
