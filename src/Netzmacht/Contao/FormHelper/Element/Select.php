<?php


namespace Netzmacht\Contao\FormHelper\Element;

class Select extends Options
{

    /**
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct('select', $attributes);

        $this->template = 'formhelper_element_select';
    }

}
