<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2016 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Listener;

use Netzmacht\Contao\FormHelper\Event\ViewEvent;

/**
 * Class WrapperCssClassesListener.
 *
 * @package Netzmacht\Contao\FormHelper\Listener
 */
class WrapperCssClassesListener
{
    /**
     * @param ViewEvent $event.
     *
     * @return void
     */
    public function onCreateView(ViewEvent $event)
    {
        $widget     = $event->getWidget();
        $attributes = $event->getView()->getAttributes();

        if ($widget->prefix) {
            $attributes->addClass($widget->prefix);
        }

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }
    }
}
