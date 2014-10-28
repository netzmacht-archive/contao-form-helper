<?php


namespace Netzmacht\Contao\FormHelper\Element;

/**
 * Class Select is used for select menus.
 *
 * @package Netzmacht\Contao\FormHelper\Element
 */
class Select extends MultipleValues
{
    /**
     * Construct.
     *
     * @param array $attributes Default html attributes.
     */
    public function __construct($attributes = array())
    {
        parent::__construct('select', $attributes);

        $this->template = 'formhelper_element_select';
    }
}
