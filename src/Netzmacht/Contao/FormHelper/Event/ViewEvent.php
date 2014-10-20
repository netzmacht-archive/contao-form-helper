<?php

namespace Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Contao\FormHelper\View;
use Symfony\Component\EventDispatcher\Event;

class ViewEvent extends Event
{
    /**
     * @var View
     */
    private $view;

    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view   = $view;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return \Widget
     */
    public function getWidget()
    {
        return $this->view->getWidget();
    }

    /**
     * @return \FormModel|null
     */
    public function getFormModel()
    {
        return $this->view->getFormModel();
    }

    /**
     * @return \Netzmacht\Html\Attributes
     */
    public function getAttributes()
    {
        return $this->view->getAttributes();
    }

    /**
     * @return \Netzmacht\Contao\FormHelper\Partial\Container
     */
    public function getContainer()
    {
        return $this->view->getContainer();
    }

    /**
     * @return \Netzmacht\Contao\FormHelper\Partial\Label
     */
    public function getLabel()
    {
        return $this->view->getLabel();
    }

    /**
     * @return \Netzmacht\Contao\FormHelper\Partial\Errors
     */
    public function getErrors()
    {
        return $this->view->getErrors();
    }
}
