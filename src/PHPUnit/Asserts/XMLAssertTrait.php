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

use GeckoPackages\PHPUnit\Constraints\XML\XMLMatchesXSDConstraint;
use GeckoPackages\PHPUnit\Constraints\XML\XMLValidConstraint;

/**
 * Additional PHPUnit asserts for testing XML based logic.
 *
 * @requires PHPUnit >= 3.0.0 (https://phpunit.de/)
 * @requires libxml (https://secure.php.net/manual/en/book.libxml.php)
 *
 * @api
 *
 * @author SpacePossum
 */
trait XMLAssertTrait
{
    /**
     * Assert string is XML formatted as defined by the XML Schema Definition.
     *
     * @param string $XML
     * @param string $XSD
     * @param string $message
     */
    public static function assertXMLMatchesXSD($XSD, $XML, $message = '')
    {
        if (!is_string($XSD)) {
            throw AssertHelper::createArgumentException(__TRAIT__, 'assertXMLMatchesXSD', 'string', $XSD);
        }

        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertXMLMatchesXSD', array('assertThat'));
        self::assertThat($XML, new XMLMatchesXSDConstraint($XSD), $message);
    }

    /**
     * Assert string is valid XML.
     *
     * @param string $XML
     * @param string $message
     */
    public static function assertXMLValid($XML, $message = '')
    {
        AssertHelper::assertMethodDependency(__CLASS__, __TRAIT__, 'assertXMLValid', array('assertThat'));
        self::assertThat($XML, new XMLValidConstraint(), $message);
    }
}
