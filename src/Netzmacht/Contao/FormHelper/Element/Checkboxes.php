<?php

namespace Netzmacht\Contao\FormHelper\Element;

class Checkboxes extends MultipleValues
{

    /**
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct('fieldset', $attributes);

        $this->template = 'formhelper_element_checkboxes';
    }
}
