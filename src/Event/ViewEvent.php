<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Event;

use Contao\Widget;
use Netzmacht\Contao\FormHelper\View;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ViewEvent is used for events passing the view.
 *
 * @package Netzmacht\Contao\FormHelper\Event
 */
class ViewEvent extends Event
{
    /**
     * The current widget view.
     *
     * @var View
     */
    private $view;

    /**
     * Construct the event.
     *
     * @param View $view The view.
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * Get the widget viw.
     *
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Shortcut to get the widget.
     *
     * @return Widget
     */
    public function getWidget()
    {
        return $this->view->getWidget();
    }

    /**
     * Return the current form model.
     *
     * @return \FormModel|null
     */
    public function getFormModel()
    {
        return $this->view->getFormModel();
    }
}
