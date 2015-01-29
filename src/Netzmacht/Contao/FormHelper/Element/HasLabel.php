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

use Netzmacht\Contao\FormHelper\Partial\Label;

/**
 * Interface HasLabel describes components having a label.
 *
 * @package Netzmacht\Contao\FormHelper\Element
 */
interface HasLabel
{
    /**
     * Set the label.
     *
     * @param Label|string $label Can be a string or any CastsToString element.
     *
     * @return mixed
     */
    public function setLabel($label);

    /**
     * Get the current label of the element.
     *
     * @return Label|string
     */
    public function getLabel();
}
