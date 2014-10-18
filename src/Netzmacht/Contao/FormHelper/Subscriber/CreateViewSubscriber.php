<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Subscriber;


use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreateViewSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private static $noColumns = array(
        'explanation',
        'html',
        'headline'
    );

    /**
     * @{inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CREATE_VIEW => array(
                'setLayout',
                'setMessageLayout',
            ),
        );
    }

    /**
     * @param ViewEvent $event
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

}