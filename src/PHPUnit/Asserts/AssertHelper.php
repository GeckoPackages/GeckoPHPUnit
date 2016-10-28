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
     * @param string   $methodName         called method name
     * @param string[] $methodDependencies method dependencies
     */
    public static function assertMethodDependency($class, $trait, $methodName, array $methodDependencies)
    {
        $missing = [];
        foreach ($methodDependencies as $methodDependency) {
            if (!method_exists($class, $methodDependency)) {
                $missing[] = sprintf('"%s"', $methodDependency);
            }
        }

        if (0 === count($missing)) {
            return;
        }

        $message = sprintf('Relies on missing %s %s', count($missing) > 1 ? 'methods' : 'method', implode(', ', $missing));
        throw self::createException($trait, $methodName, $message);
    }

    /**
     * @param string $trait      name of the trait used
     * @param string $methodName called method name
     * @param string $message
     *
     * @return \PHPUnit_Framework_Exception
     */
    public static function createException($trait, $methodName, $message)
    {
        return new \PHPUnit_Framework_Exception(
            sprintf(
                '%s::%s() %s.',
                substr($trait, strrpos($trait, '\\') + 1),
                $methodName,
                $message
            )
        );
    }

    /**
     * @param string $trait      name of the trait used
     * @param string $methodName called method name
     * @param string $typeValue  expected type description
     * @param mixed  $value      given value
     * @param int    $index      argument position
     *
     * @return \PHPUnit_Framework_Exception
     */
    public static function createArgumentException($trait, $methodName, $typeValue, $value, $index = 1)
    {
        if (is_object($value)) {
            $value = sprintf('%s#%s', get_class($value), method_exists($value, '__toString') ? $value->toString() : '');
        } else {
            $value = gettype($value).'#'.$value;
        }

        return new \PHPUnit_Framework_Exception(
            sprintf(
                'Argument #%d (%s) of %s::%s() must be %s.',
                $index,
                $value,
                substr($trait, strrpos($trait, '\\') + 1),
                $methodName,
                (in_array($typeValue[0], ['a', 'e', 'i', 'o', 'u'], true) ? 'an' : 'a').' '.$typeValue
            )
        );
    }
}
