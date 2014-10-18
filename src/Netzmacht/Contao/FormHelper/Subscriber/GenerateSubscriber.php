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
use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GenerateSubscriber implements EventSubscriberInterface
{
    /**
     * @{inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::GENERATE => array(
                array('generateCaptcha', 1000),
                array('generatePasswordConfirmation')
            )
        );
    }

    /**
     * @param ViewEvent $event
     */
    public function generateCaptcha(ViewEvent $event)
    {
        $view      = $event->getView();
        $widget    = $view->getWidget();
        $container = $view->getContainer();

        if ($widget->type == 'captcha') {
            /** @var \FormCaptcha $widget */
            $question = $widget->generateQuestion();
            $container->addChild('question', $question);
        }
    }

    /**
     * @param ViewEvent $event
     */
    public function generatePasswordConfirmation(ViewEvent $event)
    {
        $view   = $event->getView();
        $widget = $view->getWidget();

        if (!$widget instanceof \FormPassword) {
            return;
        }

        $container = $view->getContainer();
        $element   = $container->getElement();
        $label     = $view->getLabel();
        $id        = $element instanceof Element ? $element->getId() : ('ctrl_' . $widget->id);

        $repeatId    = $id . '_confirm';
        $repeatLabel = Element::create('label')
            ->setAttribute('class', $label->getAttribute('class'))
            ->addChild(sprintf($GLOBALS['TL_LANG']['MSC']['confirmation'], $widget->label))
            ->setAttribute('for', $repeatId);

        if ($widget->mandatory) {
            $mandatory = sprintf(
                '<span class="mandatory"><span class="invisible">%s</span>*</span>',
                $GLOBALS['TL_LANG']['MSC']['mandatory']
            );

            $repeatLabel->addChild($mandatory);
        }

        /** @var Element $repeat */
        $repeat = clone $element;
        $repeat->setId($repeatId)
            ->setAttribute('name', $repeat->getAttribute('name') . '_confirm')
            ->setAttribute('value', '');

        $container->addChild('repeat', $repeat);
        $container->addChild('repeatLabel', $repeatLabel);
    }
} 