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

final class FilePermissionsMaskConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var int
     */
    private $mask;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $filename
     * @param string $type     Type being tested, for example: link, file, directory.
     * @param int    $mask
     */
    public function __construct($mask, $filename, $type)
    {
        parent::__construct();
        $this->filename = $filename;
        $this->type = $type;
        $this->mask = $mask;
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other)
    {
        return ($other & $this->mask) === $this->mask;
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        return sprintf('permission "%o" of %s "%s" %s', $other, $this->type, $this->filename, $this->toString());
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return sprintf('matches mask "%o"', $this->mask);
    }
}
