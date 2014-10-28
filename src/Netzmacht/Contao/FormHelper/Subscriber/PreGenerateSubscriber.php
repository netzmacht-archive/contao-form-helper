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


use Netzmacht\Contao\FormHelper\Element\HasLabel;
use Netzmacht\Contao\FormHelper\Element\Options;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Html\Element;
use Netzmacht\Html\Element\StaticHtml;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class PreGenerateSubscriber sets default presets for Contao form widgets.
 *
 * @package Netzmacht\Contao\FormHelper\Subscriber
 */
class PreGenerateSubscriber implements EventSubscriberInterface
{
    /**
     * Elements with no label by default.
     *
     * @var array
     */
    protected static $noLabel = array('explanation', 'headline', 'html', 'submit');

    /**
     * Get all subscribed events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::PRE_GENERATE_VIEW => array(
                array('presetElement'),
                array('presetAttributes'),
                array('presetSubmit'),
                array('presetOptions'),
                array('presetLabel'),
                array('presetErrors'),
            ),
        );
    }

    /**
     * Handle ViewEvent to preset all settings.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function presetElement(ViewEvent $event)
    {
        $view    = $event->getView();
        $widget  = $view->getWidget();
        $element = $view->getContainer()->getElement();

        // unknown element type
        if (!$element instanceof Element) {
            return;
        }

        $element->setId('ctrl_' . $widget->id);
        $element->addClass($widget->type);
    }

    /**
     * Preset all html attributes.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function presetAttributes(ViewEvent $event)
    {
        $view    = $event->getView();
        $widget  = $view->getWidget();
        $element = $view->getContainer()->getElement();

        // unknown element type
        if (!$element instanceof Element) {
            return;
        }

        $this->addClasses($widget, $element);
        $this->addValue($widget, $element);
        $this->setMandatoryAttribute($widget, $element);
        $this->transformAttributes($widget, $element);
        $this->setSizeAttribute($widget, $element);
    }

    /**
     * Preset the submit button.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function presetSubmit(ViewEvent $event)
    {
        $view      = $event->getView();
        $widget    = $view->getWidget();
        $container = $view->getContainer();
        $element   = $container->getElement();

        if ($widget->type == 'submit') {
            if (!$element instanceof Element) {
                return;
            }

            $element->setAttribute('value', $widget->slabel);

            if (!$widget->imageSubmit) {
                return;
            }

            $element->setAttribute('type', 'image');

            if (version_compare(VERSION, '3', '>=')) {
                $path = \FilesModel::findByPk($widget->singleSRC)->path;
            } else {
                $path = $widget->singleSRC;
            }

            $element->setAttribute('src', $path);
            $element->setAttribute('title', $widget->slabel);

            if ($widget->imageSubmit) {
                $element
                    ->setAttribute('type', 'image')
                    ->setAttribute('src', \FilesModel::findByPk($widget->singleSRC)->path);
            }

        } elseif ($widget->addSubmit) {
            $submit = Element::create('input');
            $submit->setAttribute('type', 'submit');
            $submit->setAttribute('value', $widget->slabel);

            $container->addChild('submit', $submit);
        }
    }

    /**
     * Preset all options.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function presetOptions(ViewEvent $event)
    {
        $view    = $event->getView();
        $widget  = $view->getWidget();
        $element = $view->getContainer()->getElement();

        if ($element instanceof Options) {
            $element->setValue($widget->value);
            $element->setOptions($widget->options);
        }
    }

    /**
     * Preset error element.
     *
     * @param ViewEvent $event Element listened to.
     *
     * @return void
     */
    public function presetErrors(ViewEvent $event)
    {
        $errors = $event->getView()->getErrors();
        $errors->addClass('error');
    }


    /**
     * Preset the label.
     *
     * @param ViewEvent $event Event listened to.
     *
     * @return void
     */
    public function presetLabel(ViewEvent $event)
    {
        $view    = $event->getView();
        $label   = $view->getLabel();
        $widget  = $view->getWidget();
        $element = $view->getContainer()->getElement();

        $label->setAttribute('for', 'ctrl_' . $widget->id);

        if ($widget->label) {
            $label->addChild($widget->label);
        }

        if ($widget->mandatory) {
            $mandatory = $this->generateMandatoryLabel();

            $label->addChild($mandatory);
        }

        if ($element instanceof HasLabel) {
            $element->setLabel(new StaticHtml($widget->label));
        }

        if (in_array($widget->type, static::$noLabel)) {
            $label->hide();
        }
    }

    /**
     * Generate the mandatory label.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function generateMandatoryLabel()
    {
        return sprintf(
            '<span class="mandatory"><span class="invisible">%s</span>*</span>',
            $GLOBALS['TL_LANG']['MSC']['mandatory']
        );
    }

    /**
     * Add css classes from a widget to the element.
     *
     * @param \Widget $widget  The form widget.
     * @param Element $element The widget element.
     *
     * @return void
     */
    public function addClasses(\Widget $widget, Element $element)
    {
        if ($widget->class) {
            $classes = trimsplit(' ', $widget->class);
            $element->addClasses($classes);
        }
    }

    /**
     * Set the value to the widget. Depending on widget type it's added as child or as attribute.
     *
     * @param \Widget $widget  The form widget.
     * @param Element $element The widget element.
     *
     * @return void
     */
    public function addValue($widget, Element $element)
    {
        if ($widget->value) {
            if ($element->getTag() == 'textarea' && $element instanceof Element\Node) {
                $element->addChild($widget->value);
            } elseif ($element->getTag() == 'input') {
                $element->setAttribute('value', $widget->value);
            }
        }
    }

    /**
     * Set the mandatory attribute.
     *
     * @param \Widget $widget  The form widget.
     * @param Element $element The widget element.
     *
     * @return void
     */
    public function setMandatoryAttribute($widget, Element $element)
    {
        if ($widget->mandatory) {
            $element->setAttribute('required', true);
        }
    }

    /**
     * Transform widget attributes to element attributes.
     *
     * @param \Widget $widget  The form widget.
     * @param Element $element The widget element.
     *
     * @return void
     */
    public function transformAttributes($widget, Element $element)
    {
        $transform = array('tabindex', 'accesskey', 'maxlength', 'placeholder', 'value');

        foreach ($transform as $attribute) {
            if ($widget->$attribute) {
                $element->setAttribute($attribute, $widget->$attribute);
            }
        }
    }

    /**
     * Set the size attribute for upload fields.
     *
     * @param \Widget $widget  The form widget.
     * @param Element $element The widget element.
     *
     * @return void
     */
    public function setSizeAttribute($widget, Element $element)
    {
        if ($widget instanceof \FormFileUpload && $widget->size) {
            $element->setAttribute('size', $widget->size);
        }
    }
}
