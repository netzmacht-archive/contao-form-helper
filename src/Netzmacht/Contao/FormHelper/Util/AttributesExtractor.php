<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Util;


class AttributesExtractor
{
    /**
     * Get attributes from
     * @param \Widget $widget
     *
     * @return mixed
     */
    public static function getAttributes(\Widget $widget)
    {
        $reflector = new \ReflectionObject($widget);
        $property  = $reflector->getProperty('arrAttributes');
        $property->setAccessible(true);

        return $property->getValue($widget);
    }
}
