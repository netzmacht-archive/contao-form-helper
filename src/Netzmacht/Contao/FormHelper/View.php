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

use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Contao\FormHelper\Partial\Errors;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Contao\FormHelper\Util\Widget as WidgetUtil;
use Netzmacht\Html\Attributes;
use Widget;

/**
 * Class View handles the widget rendering process.
 *
 * @package Netzmacht\Contao\FormHelper
 */
class View
{
    /**
     * The form widget.
     *
     * @var Widget
     */
    private $widget;

    /**
     * View attributes are used for a wrapping element.
     *
     * @var Attributes
     */
    private $attributes;

    /**
     * The chosen view layout.
     *
     * @var string
     */
    private $layout;

    /**
     * Form model if widget is part of the form generator.
     *
     * @var \FormModel
     */
    private $formModel;

    /**
     * The container component.
     *
     * @var Container
     */
    private $container;

    /**
     * The widget label.
     *
     * @var Label
     */
    private $label;

    /**
     * The widget error messages.
     *
     * @var Errors
     */
    private $errors;

    /**
     * State of visibility. A view can be hidden completely.
     *
     * @var bool
     */
    private $visible = true;

    /**
     * The widget type.
     *
     * @var string
     */
    private $widgetType;

    /**
     * Construct.
     *
     * @param \Widget    $widget    The form widget.
     * @param \FormModel $formModel Optional the corresponding form model.
     */
    public function __construct(\Widget $widget, \FormModel $formModel = null)
    {
        $this->widget     = $widget;
        $this->formModel  = $formModel;
        $this->attributes = new Attributes();
        $this->container  = new Container();
        $this->label      = new Label();
        $this->errors     = new Errors($widget->getErrors());
        $this->widgetType = WidgetUtil::getType($widget);
    }

    /**
     * Get the form widget.
     *
     * @return Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * Get widget type.
     *
     * @return string
     */
    public function getWidgetType()
    {
        return $this->widgetType;
    }

    /**
     * Set the view layout.
     *
     * @param string $layout The layout name.
     *
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the layout name.
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Get the view attributes.
     *
     * @return Attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get the visible state of the view.
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * Set the visibile state.
     *
     * @param bool $visible The visible state.
     *
     * @return $this
     */
    public function setVisible($visible)
    {
        $this->visible = (bool) $visible;

        return $this;
    }


    /**
     * Render the view.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->isVisible()) {
            return '';
        }

        $name     = 'formhelper_layout_' . $this->getLayout();
        $template = new \FrontendTemplate($name);

        $template->widget     = $this->widget;
        $template->container  = $this->container;
        $template->label      = $this->label;
        $template->attributes = $this->attributes;
        $template->errors     = $this->errors;

        return $template->parse();
    }

    /**
     * Get the form model.
     *
     * @return \FormModel|null
     */
    public function getFormModel()
    {
        return $this->formModel;
    }

    /**
     * Consider if a form model is given.
     *
     * @return bool
     */
    public function hasFormModel()
    {
        return ($this->formModel !== null);
    }

    /**
     * Get the container.
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the view errors.
     *
     * @return Errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the label.
     *
     * @return Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the view label.
     *
     * @param Label $label The view label.
     *
     * @return $this
     */
    public function setLabel(Label $label)
    {
        $this->label = $label;

        return $this;
    }
}
