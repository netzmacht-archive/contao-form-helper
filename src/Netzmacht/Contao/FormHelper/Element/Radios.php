<?php

namespace Netzmacht\Contao\FormHelper\Element;

/**
 * Class Radios is used for radio menu.
 *
 * @package Netzmacht\Contao\FormHelper\Element
 */
class Radios extends MultipleValues
{
    /**
     * Construct.
     *
     * @param array $attributes Default html attributes.
     */
    public function __construct($attributes = array())
    {
        parent::__construct('fieldset', $attributes);

        $this->template = 'formhelper_element_radios';
    }

    /**
     * {@inheritdoc}
     */
    public function isElementCollection()
    {
        return true;
    }
}
