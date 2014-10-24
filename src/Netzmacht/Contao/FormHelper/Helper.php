<?php

namespace Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\CreateElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Form\FormLocator;
use Netzmacht\Html\Element\StaticHtml;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Helper
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var FormLocator
     */
    private $formLocator;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param FormLocator              $formLocator
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FormLocator $formLocator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formLocator     = $formLocator;
    }

    /**
     * @return Helper
     */
    public static function getInstance()
    {
        return $GLOBALS['container']['form-helper'];
    }

    /**
     * @param  \Widget $widget
     * @param  bool $return
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
     * @param  \Widget $widget
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
     * @param  \Widget $widget
     * @param  $view
     * @return \Netzmacht\Html\Element|\Netzmacht\Html\Element\StaticHtml
     */
    private function buildElement(\Widget $widget, $view)
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
     * @param  \Widget $widget
     * @param  $form
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
     * @param $view
     */
    private function dispatchPreGenerate(View $view)
    {
        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::PRE_GENERATE_VIEW, $event);
    }

    /**
     * @param View $view
     */
    public function dispatchGenerate(View $view)
    {
        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::GENERATE_VIEW, $event);
    }
}
