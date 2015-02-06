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
 * Widget util provides access to widget attributes.
 *
 * @package Netzmacht\Contao\FormHelper\Util
 */
class Widget
{
    /**
     * Get all attributes of the widget.
     *
     * @param \Widget $widget The widget.
     *
     * @return array
     */
    public static function getAttributes($widget)
    {
        return Spy::spyAttributes($widget);
    }

    /**
     * Get the widget type.
     *
     * @param \Widget $widget The widget.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getType($widget)
    {
        $config = Spy::spyConfiguration($widget);

        if (isset($config['type'])) {
            return $config['type'];
        }

        // Try to get widget type from class
        if (!$widget->type) {
            $elements    = array_flip($GLOBALS['TL_FFL']);
            $widgetClass = get_class($widget);

            if (isset($elements[$widgetClass])) {
                return $elements[$widgetClass];
            } elseif (strpos($widgetClass, 'Contao\\') === 0) {
                $widgetClass = substr($widgetClass, 7);

                if (isset($elements[$widgetClass])) {
                    return $elements[$widgetClass];
                }
            }
        }

        return $widget->type;
    }
}
