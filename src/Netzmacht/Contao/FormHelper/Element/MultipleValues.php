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

class MultipleValues extends Options implements HasLabel
{
    /**
     * @var Label|string
     */
    private $label;

    /**
     * @param Label|string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Label|string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string|void
     */
    public function generate()
    {
        $template             = new \FrontendTemplate($this->template);
        $template->options    = $this->options;
        $template->element    = $this;
        $template->tag        = $this->getTag();
        $template->label      = $this->label;

        return $template->parse();
    }
}
