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

class PreGenerateSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    protected static $noLabel = array('explanation', 'headline', 'html', 'submit');

    /**
     * @{inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::PRE_GENERATE => array(
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
     * @param ViewEvent $event
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
     * @param ViewEvent $event
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

        if ($widget->class) {
            $classes = trimsplit(' ', $widget->class);
            $element->addClasses($classes);
        }

        if ($widget->value) {
            if ($element->getTag() == 'textarea' && $element instanceof Element\Node) {
                $element->addChild($widget->value);
            } elseif ($element->getTag() == 'input') {
                $element->setAttribute('value', $widget->value);
            }
        }

        if ($widget->mandatory) {
            $element->setAttribute('required', true);
        }

        $transform = array('tabindex', 'accesskey', 'maxlength', 'placeholder', 'value');

        foreach ($transform as $attribute) {
            if ($widget->$attribute) {
                $element->setAttribute($attribute, $widget->$attribute);
            }
        }

        if ($widget instanceof \FormFileUpload && $widget->size) {
            $element->setAttribute('size', $widget->size);
        }
    }

    /**
     * @param ViewEvent $event
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
     * @param ViewEvent $event
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
     * @param ViewEvent $event
     */
    public function presetErrors(ViewEvent $event)
    {
        $errors = $event->getView()->getErrors();
        $errors->addClass('error');
    }


    /**
     * @param ViewEvent $event
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
            $mandatory = sprintf(
                '<span class="mandatory"><span class="invisible">%s</span>*</span>',
                $GLOBALS['TL_LANG']['MSC']['mandatory']
            );

            $label->addChild($mandatory);
        }

        if ($element instanceof HasLabel) {
            $element->setLabel(new StaticHtml($widget->label));
        }

        if (in_array($widget->type, static::$noLabel)) {
            $label->hide();
        }
    }
}
