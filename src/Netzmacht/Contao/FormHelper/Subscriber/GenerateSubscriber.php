<?php

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
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class GenerateSubscriber renders the element. It is used for captcha and password confirmation elements which
 * requires a special setup.
 *
 * @package Netzmacht\Contao\FormHelper\Subscriber
 */
class GenerateSubscriber implements EventSubscriberInterface
{
    /**
     * Get all subscribed events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::GENERATE_VIEW => array(
                array('generateCaptcha', 1000),
                array('generatePasswordConfirmation')
            )
        );
    }

    /**
     * Generate the captcha element.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
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

            // make sure that submit button will be shown after question
            $container->rearrangeChildren(array('question', 'submit'));
        }
    }

    /**
     * Generate the password confirmation field.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
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
        $widgetId  = $element instanceof Element ? $element->getId() : ('ctrl_' . $widget->id);

        $repeatId    = $widgetId . '_confirm';
        $repeatLabel = new Label();
        $repeatLabel
            ->setAttribute('class', $label->getAttribute('class'))
            ->addChild($this->createConfirmationLabel($widget))
            ->setAttribute('for', $repeatId);

        if ($widget->mandatory) {
            $mandatory = $this->createMandatoryLabel();

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

    /**
     * Create the mandatory label.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function createMandatoryLabel()
    {
        return sprintf(
            '<span class="mandatory"><span class="invisible">%s</span>*</span>',
            $GLOBALS['TL_LANG']['MSC']['mandatory']
        );
    }

    /**
     * Create the confirmation label.
     *
     * @param \Widget $widget The form widget.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function createConfirmationLabel(\Widget $widget)
    {
        return sprintf($GLOBALS['TL_LANG']['MSC']['confirmation'], $widget->label);
    }
}
