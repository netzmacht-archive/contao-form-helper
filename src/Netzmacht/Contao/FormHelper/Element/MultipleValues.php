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
use Netzmacht\Html\CastsToString;

/**
 * Class MultipleValues is a base class for widets with multiple values.
 *
 * @package Netzmacht\Contao\FormHelper\Element
 */
class MultipleValues extends Options implements HasLabel
{
    /**
     * The label.
     *
     * @var Label|CastsToString|string
     */
    private $label;

    /**
     * Set the label.
     *
     * @param Label|string $label Assign a label.
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the label.
     *
     * @return Label|string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Consider if element is an element collection.
     *
     * Used to map contao widgets attributes to children instead of the element itself.
     *
     * @return bool
     */
    public function isElementCollection()
    {
        return false;
    }

    /**
     * Generate the element.
     *
     * @return string
     */
    public function generate()
    {
        $template             = new \FrontendTemplate($this->template);
        $template->options    = $this->options;
        $template->element    = $this;
        $template->tag        = $this->getTag();
        $template->label      = $this->label;
        $template->attributes = (array) $this->childAttributes->getAttributes();

        return $template->parse();
    }
}
