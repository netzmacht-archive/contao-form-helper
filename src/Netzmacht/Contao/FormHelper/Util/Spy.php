<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Util;

/**
 * Class Spy is used to retrieve information from the widget which are not accessible usually.
 *
 * It uses the not very well known visibility implementation of PHP which allows other objects of the same class
 * to access the attributes.
 *
 * You should not use the spy directly. It's working in the dark. Use the Widget util instead.
 *
 * @package Netzmacht\Contao\FormHelper\Util
 */
abstract class Spy extends \Widget
{
    /**
     * Retrieve the attributes of an widget.
     *
     * @param \Widget $widget The widget.
     *
     * @return array
     */
    public static function spyAttributes(\Widget $widget)
    {
        return $widget->arrAttributes;
    }

    /**
     * Retrieve the configuration of an widget.
     *
     * @param \Widget $widget The widget.
     *
     * @return array
     */
    public static function spyConfiguration($widget)
    {
        return $widget->arrConfiguration;
    }
}
