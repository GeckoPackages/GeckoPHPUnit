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
final class DirectoryEmptyConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        if (!is_string($other) || !is_dir($other)) {
            return false;
        }

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
        if (is_object($other)) {
            $type = sprintf('%s#%s', get_class($other), method_exists($other, '__toString') ? $other->__toString() : '');
        } elseif (null === $other) {
            $type = 'null';
        } elseif (!is_string($other)) {
            $type = gettype($other).'#'.$other;
        } elseif (is_link($other)) {
            $type = 'link to file#'.$other;
        } elseif (is_file($other)) {
            $type = 'file#'.$other;
        } elseif (is_dir($other)) {
            $type = 'directory#'.$other;
        } else {
            $type = $other;
        }

        return $type.' is an empty directory';
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return 'is an empty directory';
    }
}
