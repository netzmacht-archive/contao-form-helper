<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Subscriber;

use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateViewSubscriber subscribes the create view event is created the defualt view instance.
 *
 * @package Netzmacht\Contao\FormHelper\Subscriber
 */
class CreateViewSubscriber implements EventSubscriberInterface
{
    /**
     * Elements which won't have any columns by default.
     *
     * @var array
     */
    private static $noColumns = array(
        'explanation',
        'html',
        'headline'
    );

    /**
     * Get all subscribed events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CREATE_VIEW => array(
                array('setLayout'),
                array('setCssClasses'),
            ),
        );
    }

    /**
     * Select the view layout.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function setLayout(ViewEvent $event)
    {
        $view   = $event->getView();
        $widget = $view->getWidget();
        $form   = $view->getFormModel();

        // form can be null if form is not created from form generator
        if ($form && $form->tableless) {
            $view->setLayout('tableless');
        } elseif (in_array($widget->type, static::$noColumns)) {
            $view->setLayout('table_nocolumns');
        } else {
            $view->setLayout('table');
        }
    }

    /**
     * Set all css classes to the widget attributes.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function setCssClasses(ViewEvent $event)
    {
        $view       = $event->getView();
        $widget     = $view->getWidget();
        $attributes = $view->getAttributes();

        $attributes
            ->addClass('widget')
            ->addClass('widget-' . $widget->type);

        if ($widget->mandatory) {
            $attributes->addClass('mandatory');
        }
    }
}
