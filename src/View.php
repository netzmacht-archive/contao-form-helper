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

use Contao\FormModel;
use Contao\Widget;
use Netzmacht\Contao\FormHelper\Util\WidgetUtil;

/**
 * Class View handles the widget rendering process.
 *
 * @package Netzmacht\Contao\FormHelper
 */
class View
{
    const BLOCK_BEFORE_LABEL = 'before-label';
    const BLOCK_AFTER_LABEL  = 'after-label';
    const BLOCK_BEFORE_FIELD = 'before-field';
    const BLOCK_AFTER_FIELD  = 'after-field';
    
    /**
     * The form widget.
     *
     * @var Widget
     */
    private $widget;

    /**
     * Block.
     *
     * @var array
     */
    private $blocks = [];

    /**
     * Form model if widget is part of the form generator.
     *
     * @var \FormModel
     */
    private $formModel;

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
     * @param Widget    $widget    The form widget.
     * @param FormModel $formModel Optional the corresponding form model.
     */
    public function __construct(Widget $widget, FormModel $formModel = null)
    {
        $this->widget     = $widget;
        $this->formModel  = $formModel;
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
     * Add a block content.
     *
     * @param string   $blockName Block name.
     * @param string   $content   Content being added to a block.
     * @param int|null $position  Position of the content.
     *
     * @return $this
     */
    public function addBlockContent($blockName, $content, $position = null)
    {
        $this->blocks[$blockName][] = $content;

        return $this;
    }

    /**
     * Get content of a block.
     *
     * @param string $blockName The block name.
     * @param bool   $flatten   If false an array instead of a string is returned.
     *
     * @return array|string
     */
    public function block($blockName, $flatten = true)
    {
        if (!isset($this->blocks[$blockName])) {
            return $flatten ? '' : [];
        }

        if ($flatten) {
            return implode("\n", $this->blocks[$blockName]);
        }

        return $this->blocks[$blockName];
    }
}
