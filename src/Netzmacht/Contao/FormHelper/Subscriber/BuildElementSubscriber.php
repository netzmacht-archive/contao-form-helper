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


use Netzmacht\Contao\FormHelper\Element\Checkboxes;
use Netzmacht\Contao\FormHelper\Element\Radios;
use Netzmacht\Contao\FormHelper\Element\Select;
use Netzmacht\Contao\FormHelper\Event\CreateElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\GeneratesAnElement;
use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BuildElementSubscriber implements EventSubscriberInterface
{
    /**
     * @{inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::BUILD_ELEMENT => 'buildElement'
        );
    }

    /**
     * @param BuildElementEvent $event
     */
    public function buildElement(CreateElementEvent $event)
    {
        $widget  = $event->getWidget();
        $element = null;

        if ($this->buildByWidget($event, $widget)) {
            return;
        }

        switch ($widget->type) {
            case 'explanation':
            case 'headline':
                $element = Element::create('div');
                $element->addChild($widget->text);
                break;

            case 'html':
                $element = Element::create('div');
                $element->addChild($widget->html);
                break;

            case 'checkbox':
                $element = new Checkboxes();
                $element->setAttribute('name', $widget->name);
                break;

            case 'radio':
                $element = new Radios();
                $element->setAttribute('name', $widget->name);
                break;

            case 'captcha':
                // generate question to fetch the name of the captcha element, see #1
                /** @var \FormCaptcha $widget */
                $widget->generateQuestion();

                $name    = \Session::getInstance()->get('captcha_' . $widget->id);
                $element = Element::create('input', array('type' => 'text'));

                $element->setAttribute('name', $name['key']);
                break;

            case 'upload':
                $element = Element::create('input', array('type' => 'file'));
                $element->setAttribute('name', $widget->name);
                break;

            case 'password':
            case 'submit':
            case 'text':
            case 'digit':
            case 'email':
            case 'tel':
            case 'url':
                $element = Element::create('input', array('type' => $widget->type));
                $element->setAttribute('name', $widget->name);
                break;

            case 'textarea':
                $element = Element::create($widget->type);
                $element->setAttribute('name', $widget->name);
                break;

            case 'select':
                $element = new Select();
                $element->setAttribute('name', $widget->name);
                break;

            default:
                return;
        }

        $event->setElement($element);
    }

    /**
     * @param BuildElementEvent $event
     * @param $widget
     * @return bool
     */
    private function buildByWidget(CreateElementEvent $event, $widget)
    {
        if ($widget instanceof GeneratesAnElement) {
            $element = $widget->generate();
            $event->setElement($element);

            return true;
        }

        return false;
    }
}
