<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\CreateElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Form\FormLocator;
use Netzmacht\Html\Element\StaticHtml;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Helper is the main entry poing for generating form widget elements.
 *
 * @package Netzmacht\Contao\FormHelper
 */
class Helper
{
    /**
     * The event dispatcher.
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * The form locator.
     *
     * @var FormLocator
     */
    private $formLocator;

    /**
     * Construct.
     *
     * @param EventDispatcherInterface $eventDispatcher The event dispatcher.
     * @param FormLocator              $formLocator     The form locator.
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FormLocator $formLocator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formLocator     = $formLocator;
    }

    /**
     * Get instance method is used to load the form helper from the dependency container.
     *
     * @return Helper The form helper instance.
     *
     * @SuppressWarnings(Superglobals)
     */
    public static function getInstance()
    {
        return $GLOBALS['container']['form-helper'];
    }

    /**
     * Generate a widet.
     *
     * @param \Widget $widget The form widget.
     * @param bool    $return If true the output won't be echoed. Instead it will be returned.
     *
     * @return string|void
     */
    public static function generate(\Widget $widget, $return = false)
    {
        $helper = static::getInstance();
        $view   = $helper->createView($widget);
        $buffer = $view->render();

        if ($return) {
            return $buffer;
        }

        echo $buffer;
    }

    /**
     * Create a view for a widget.
     *
     * @param \Widget $widget The form wiedget.
     *
     * @return View
     */
    public function createView(\Widget $widget)
    {
        $form    = $this->formLocator->getForm($widget->pid);
        $view    = $this->buildView($widget, $form);
        $element = $this->buildElement($widget, $view);

        $view->getContainer()->setElement($element);

        $this->dispatchPreGenerate($view);
        $this->dispatchGenerate($view);

        return $view;
    }

    /**
     * Build the element.
     *
     * @param \Widget $widget The form widget.
     * @param View    $view   The view instance.
     *
     * @return \Netzmacht\Html\Element|\Netzmacht\Html\Element\StaticHtml
     */
    private function buildElement(\Widget $widget, View $view)
    {
        // build the element
        $event = new CreateElementEvent($view);
        $this->eventDispatcher->dispatch(Events::CREATE_ELEMENT, $event);

        $element = $event->getElement();

        // no element given by build event. generate form widget instead
        if (!$element) {
            $element = new StaticHtml($widget->generate());
        }

        return $element;
    }

    /**
     * Build the widget view.
     *
     * @param \Widget         $widget The form widget.
     * @param \FormModel|null $form   A form model if it's part of the form generator.
     *
     * @return View
     */
    private function buildView(\Widget $widget, $form)
    {
        $view = new View($widget, $form);

        // create the view
        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::CREATE_VIEW, $event);

        return $view;
    }

    /**
     * Dispatch the pre generate event.
     *
     * @param View $view The widget view.
     *
     * @return void
     */
    private function dispatchPreGenerate(View $view)
    {
        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::PRE_GENERATE_VIEW, $event);
    }

    /**
     * Dispatches the generate event.
     *
     * @param View $view The widget view.
     *
     * @return void
     */
    public function dispatchGenerate(View $view)
    {
        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::GENERATE_VIEW, $event);
    }
}
