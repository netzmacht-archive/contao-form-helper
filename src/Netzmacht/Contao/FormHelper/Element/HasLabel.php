<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Element;

use Netzmacht\Contao\FormHelper\Partial\Label;

interface HasLabel
{
    /**
     * @param Label|string $label
     * @return mixed
     */
    public function setLabel($label);

    /**
     * @return Label|string
     */
    public function getLabel();

}
