<?php

namespace Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Contao\FormHelper\View;
use Symfony\Component\EventDispatcher\Event;

class ViewEvent extends Event
{
    const NAME = 'form-helper.create-view-event';

    /**
     * @var \Widget
     */
    private $widget;

    /**
     * @var View
     */
    private $view;


    /**
     * @param \Widget $widget
     * @param View $view
     */
    public function __construct(\Widget $widget, View $view)
    {
        $this->widget = $widget;
        $this->view   = $view;
    }

    /**
     * @return \Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }
}
