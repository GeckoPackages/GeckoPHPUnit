<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GeckoPackages\PHPUnit\Constraints\XML;

/**
 * @internal
 *
 * @author SpacePossum
 */
abstract class AbstractXMLConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var string[]
     */
    protected $XMLConstraintErrors = [];

    protected function setXMLConstraintErrors()
    {
        foreach (libxml_get_errors() as $error) {
            switch ($error->level) {
                case LIBXML_ERR_WARNING:{
                    $level = 'warning ';
                    break;
                }
                case LIBXML_ERR_ERROR:{
                    $level = 'error ';
                    break;
                }
                case LIBXML_ERR_FATAL:{
                    $level = 'fatal ';
                    break;
                }
                default:{
                    $level = '';
                    break;
                }
            }

            $this->XMLConstraintErrors[] = sprintf('[%s%s] %s (line %d, column %d).', $level, $error->code, trim($error->message), $error->line, $error->column);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other)
    {
        return sprintf("%s.\n%s", $this->toString(), implode("\n", $this->XMLConstraintErrors));
    }
}
