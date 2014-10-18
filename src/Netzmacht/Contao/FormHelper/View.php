<?php

namespace Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Contao\FormHelper\Partial\Errors;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Html\Attributes;
use Widget;

class View
{
    /**
     * @var Widget
     */
    private $widget;

    /**
     * @var Attributes
     */
    private $attributes;

    /**
     * @var string
     */
    private $layout;

    /**
     * @var \FormModel
     */
    private $formModel;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Label
     */
    private $label;

    /**
     * @var Errors
     */
    private $errors;

    /**
     * @param Widget $widget
     * @param \FormModel $formModel
     */
    public function __construct(\Widget $widget, \FormModel $formModel = null)
    {
        $this->widget     = $widget;
        $this->formModel  = $formModel;
        $this->attributes = new Attributes();
        $this->container  = new Container();
        $this->label      = new Label();
        $this->errors     = new Errors($widget->getErrors());
    }

    /**
     * @return Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @return Attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function render()
    {
        return '';
    }

    /**
     * @return \FormModel|null
     */
    public function getFormModel()
    {
        return $this->formModel;
    }

    /**
     * @return bool
     */
    public function hasFormModel()
    {
        return ($this->formModel !== null);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return Label
     */
    public function getLabel()
    {
        return $this->label;
    }
}
