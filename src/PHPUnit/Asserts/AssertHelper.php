<?php

/*
 * This file is part of the GeckoPackages.
 *
 * (c) GeckoPackages https://github.com/GeckoPackages
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GeckoPackages\PHPUnit\Asserts;

/**
 * Helper for building exceptions and checking dependencies.
 *
 * @internal
 *
 * @author SpacePossum
 */
final class AssertHelper
{
    /**
     * @param string   $class              name of the class using trait;
     * @param string   $trait              name of the trait calling method;
     * @param string   $method             called method name
     * @param string[] $methodDependencies list of methods the trait relies on
     */
    public static function assertMethodDependency($class, $trait, $method, array $methodDependencies)
    {
        $missing = array();
        foreach ($methodDependencies as $methodDependency) {
            if (!method_exists($class, $methodDependency)) {
                $missing[] = sprintf('"%s"', $methodDependency);
            }
        }

        if (0 === count($missing)) {
            return;
        }

        throw self::createException(
            $trait,
            $method,
            sprintf('Relies on missing %s %s', count($missing) > 1 ? 'methods' : 'method', implode(', ', $missing))
        );
    }

    /**
     * @param string $trait                   name of the trait used
     * @param string $method                  called method name
     * @param string $expectedTypeForArgument expected type description
     * @param mixed  $valueOfArgument         given value
     * @param int    $index                   argument position
     *
     * @return \PHPUnit_Framework_Exception
     */
    public static function createArgumentException($trait, $method, $expectedTypeForArgument, $valueOfArgument, $index = 1)
    {
        if (is_object($valueOfArgument)) {
            $valueOfArgument = sprintf('%s#%s', get_class($valueOfArgument), method_exists($valueOfArgument, '__toString') ? $valueOfArgument->__toString() : '');
        } elseif (null === $valueOfArgument) {
            $valueOfArgument = 'null';
        } else {
            $valueOfArgument = gettype($valueOfArgument).'#'.$valueOfArgument;
        }

        return new \PHPUnit_Framework_Exception(
            sprintf(
                'Argument #%d (%s) of %s::%s() must be %s.',
                $index,
                $valueOfArgument,
                substr($trait, strrpos($trait, '\\') + 1),
                $method,
                (in_array($expectedTypeForArgument[0], array('a', 'e', 'i', 'o', 'u'), true) ? 'an' : 'a').' '.$expectedTypeForArgument
            )
        );
    }

    /**
     * @param string $trait   name of the trait used
     * @param string $method  called method name
     * @param string $message
     *
     * @return \PHPUnit_Framework_Exception
     */
    public static function createException($trait, $method, $message)
    {
        return new \PHPUnit_Framework_Exception(
            sprintf(
                '%s::%s() %s.',
                substr($trait, strrpos($trait, '\\') + 1),
                $method,
                $message
            )
        );
    }
}
