<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Partial;

use Netzmacht\Html\Element\Node;

/**
 * Class Label is used for the form element label.
 *
 * @package Netzmacht\Contao\FormHelper\Partial
 */
class Label extends Node
{
    /**
     * Visibility of label. Is visible by default.
     *
     * @var bool
     */
    protected $visible = true;

    /**
     * Construct.
     *
     * @param array $attributes The default html attributes.
     */
    public function __construct($attributes = array())
    {
        parent::__construct('label', $attributes);
    }

    /**
     * Hide the label.
     *
     * @return $this
     */
    public function hide()
    {
        $this->visible = false;

        return $this;
    }

    /**
     * Show the label.
     *
     * @return $this
     */
    public function show()
    {
        $this->visible = true;

        return $this;
    }

    /**
     * Consider if label is visible.
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * Generate the label.
     *
     * @return string
     */
    public function generate()
    {
        if ($this->isVisible()) {
            return parent::generate();
        }

        return '';
    }
}
