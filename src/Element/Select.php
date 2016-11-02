<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */


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
