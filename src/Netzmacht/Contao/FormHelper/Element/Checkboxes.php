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
