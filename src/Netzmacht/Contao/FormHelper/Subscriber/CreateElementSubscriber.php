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

use Netzmacht\Contao\FormHelper\Element\Checkboxes;
use Netzmacht\Contao\FormHelper\Element\Radios;
use Netzmacht\Contao\FormHelper\Element\Select;
use Netzmacht\Contao\FormHelper\Event\CreateElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\GeneratesAnElement;
use Netzmacht\Contao\FormHelper\View;
use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateElementSubscriber listens to the createElement event to create the corresponding widget elements.
 *
 * @package Netzmacht\Contao\FormHelper\Subscriber
 */
class CreateElementSubscriber implements EventSubscriberInterface
{
    /**
     * Elements which are based on a text element.
     *
     * @var array
     */
    private $textBasedElements = array('password', 'submit', 'text', 'digit', 'email', 'tel', 'url', 'number');

    /**
     * Get all subscribed events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CREATE_ELEMENT => 'handleCreateElement'
        );
    }

    /**
     * Handle the CreateElementEvent and create the default element. All Contao elements are supported.
     *
     * @param CreateElementEvent $event The event listened to.
     *
     * @return void
     */
    public function handleCreateElement(CreateElementEvent $event)
    {
        $widget = $event->getWidget();
        $type   = $this->getWidgetType($event->getView());

        if ($this->buildByWidget($event, $widget) || ! $type) {
            return;
        }

        $methodName = sprintf('create%sElement', ucfirst($type));

        if (method_exists($this, $methodName)) {
            $element = $this->$methodName($widget);
            $event->setElement($element);
        } elseif (in_array($type, $this->textBasedElements)) {
            $element = $this->createTextBasedElement($widget, $type);
            $event->setElement($element);
        }
    }

    /**
     * Build the element by the widget.
     *
     * If the widget has a GeneratesAnElement event the widget generate method will be used instead of recreating the
     * elements.
     *
     * @param CreateElementEvent $event  The subscribed event.
     * @param \Widget            $widget The form widget.
     *
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

    /**
     * Create the html element.
     *
     * @param \Widget $widget The html widget.
     *
     * @return Element\Node|Element\Standalone
     */
    public function createHtmlElement($widget)
    {
        $element = Element::create('div');
        $element->addChild($widget->html);

        return $element;
    }

    /**
     * Create a checkbox element.
     *
     * @param \Widget $widget A checkbox widget.
     *
     * @return Checkboxes
     */
    public function createCheckboxElement($widget)
    {
        $element = new Checkboxes();
        $element->getChildAttributes()->setAttribute('name', $widget->name . '[]');

        return $element;
    }

    /**
     * Create a radio element.
     *
     * @param \Widget $widget The radio widget.
     *
     * @return Radios
     */
    public function createRadioElement($widget)
    {
        $element = new Radios();
        $element->getChildAttributes()->setAttribute('name', $widget->name);

        return $element;
    }

    /**
     * Create a captcha element.
     *
     * @param \Widget $widget The captcha widget.
     *
     * @return Element\Node|Element\Standalone
     */
    public function createCaptchaElement($widget)
    {
        // generate question to fetch the name of the captcha element, see #1
        /** @var \FormCaptcha $widget */
        $widget->generateQuestion();

        $name    = \Session::getInstance()->get('captcha_' . $widget->id);
        $element = Element::create('input', array('type' => 'text'));

        $element->setAttribute('name', $name['key']);

        return $element;
    }

    /**
     * Create the upload element.
     *
     * @param \Widget $widget The upload widget.
     *
     * @return Element\Node|Element\Standalone
     */
    public function createUploadElement($widget)
    {
        $element = Element::create('input', array('type' => 'file'));
        $element->setAttribute('name', $widget->name);

        return $element;
    }

    /**
     * Create a textarea element.
     *
     * @param \Widget $widget The textarea widget.
     *
     * @return Element\Node|Element\Standalone
     */
    public function createTextareaElement($widget)
    {
        $element = Element::create($widget->type);
        $element->setAttribute('name', $widget->name);

        return $element;
    }

    /**
     * Create a select element.
     *
     * @param \Widget $widget The selct widget.
     *
     * @return Select
     */
    public function createSelectElement($widget)
    {
        $element = new Select();
        $element->setAttribute('name', $widget->name);

        return $element;
    }

    /**
     * Create a text based element.
     *
     * @param \Widget $widget The form widget.
     *
     * @return Element\Node|Element\Standalone
     */
    public function createTextBasedElement($widget)
    {
        $element = Element::create('input', array('type' => $widget->type));
        $element->setAttribute('name', $widget->name);

        return $element;
    }

    /**
     * Handle widget type before return it to support 3rd party form extensions.
     *
     * @param View $view The view.
     *
     * @return string
     */
    private function getWidgetType(View $view)
    {
        $widget = $view->getWidget();
        $type   = $view->getWidgetType();

        switch ($type) {
            case 'rocksolid_antispam':
                if ($widget->type === 'captcha') {
                    return $widget->type;
                }
                break;

            default:
                return $type;
        }

        return $type;
    }
}
