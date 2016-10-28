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
final class FilePermissionsIsIdenticalConstraint extends \PHPUnit_Framework_Constraint_IsIdentical
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $type;

    /**
     * @param int|string $permissions
     * @param string     $filename
     * @param string     $type        Type being tested, for example: link, file, directory
     */
    public function __construct($permissions, $filename, $type)
    {
        parent::__construct($permissions);
        $this->filename = $filename;
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        return sprintf('permission %s of %s "%s" %s', $this->exporter->export($other), $this->type, $this->filename, $this->toString());
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        if (is_int($this->value)) {
            return sprintf('is identical to permission %d', $this->value);
        }

        return sprintf('is identical to permission "%s"', $this->value);
    }
}
