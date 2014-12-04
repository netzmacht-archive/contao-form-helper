<?php

namespace Netzmacht\Contao\FormHelper\Element;

/**
 * Class Checkboxes is used for the checkbox menu.
 *
 * @package Netzmacht\Contao\FormHelper\Element
 */
class Checkboxes extends MultipleValues
{

    /**
     * Construct.
     *
     * @param array $attributes Html attributes.
     */
    public function __construct($attributes = array())
    {
        parent::__construct('fieldset', $attributes);

        $this->template = 'formhelper_element_checkboxes';
    }

    /**
     * {@inheritdoc}
     */
    public function isElementCollection()
    {
        return true;
    }
}
