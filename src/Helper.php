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

use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\Form\FormLocator;
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
    private static function getInstance()
    {
        return \Controller::getContainer()->get('form_helper');
    }

    /**
     * Create a view for a widget.
     *
     * @param \Widget $widget The form wiedget.
     *
     * @return View
     */
    public static function createView(\Widget $widget)
    {
        $helper    = static::getInstance();
        $formModel = $helper->formLocator->getForm($widget->pid);
        $view      = $helper->buildView($widget, $formModel);

        return $view;
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

        $event = new ViewEvent($view);
        $this->eventDispatcher->dispatch(Events::GENERATE_VIEW, $event);

        return $view;
    }
}
