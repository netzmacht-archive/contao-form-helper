<?php

namespace Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\BuildElementEvent;
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
     * @param  \Widget $widget
     * @return string
     */
    public static function generate(\Widget $widget)
    {
        /** @var Helper $helper */
        $helper = $GLOBALS['container']['form-helper'];
        $view   = $helper->createView($widget);

        return $view->render();
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
        $event = new BuildElementEvent($view);
        $this->eventDispatcher->dispatch(Events::BUILD_ELEMENT, $event);

        $element = $event->getElement();

        // no element given by build event. generate form widget instead
        if (!$element) {
            $element = new StaticHtml($widget->generate());
        }

        return $element;
    }

    /**
     * @param  \Widget $widget
     * @param $form
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
        $this->eventDispatcher->dispatch(Events::PRE_GENERATE, $event);
    }

    /**
     * @param View $view
     */
    public function dispatchGenerate(View $view)
    {
        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::GENERATE, $event);
    }

}