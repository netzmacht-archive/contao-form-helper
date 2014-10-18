<?php

namespace Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\CreateViewEvent;
use Netzmacht\Contao\FormHelper\Form\FormLocator;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Contao\FormHelper\Partial\Errors;
use Netzmacht\Contao\FormHelper\Partial\Label;
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
     * @param FormLocator $formLocator
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FormLocator $formLocator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formLocator     = $formLocator;
    }

    /**
     * @param \Widget $widget
     * @return View
     */
    public function createView(\Widget $widget)
    {
        $form = $this->formLocator->getForm($widget->pid);
        $view = new View($widget, $form);

        $event = new CreateViewEvent($widget, $view);
        $this->eventDispatcher->dispatch($event::NAME, $event);

        return $view;
    }


}
