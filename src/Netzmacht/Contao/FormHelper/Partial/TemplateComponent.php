<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Partial;

use Netzmacht\Contao\FormHelper\Component;
use Netzmacht\Contao\FormHelper\Partial;
use Netzmacht\Contao\FormHelper\HasTemplate;

/**
 * Class TemplateComponent is a component which can be rendered using a template. Child classes can decide if they
 * require a template or provide it as option.
 *
 * @package Netzmacht\Contao\FormHelper\Partial
 */
class TemplateComponent extends Component implements HasTemplate
{
    /**
     * The template name.
     *
     * @var string
     */
    protected $template;

    /**
     * Set the template name.
     *
     * @param string $name The template name.
     *
     * @return $this
     *
     * @SuppressWarnings(PHPCPD)
     */
    public function setTemplateName($name)
    {
        $this->template = $name;

        return $this;
    }

    /**
     * Get the template name.
     *
     * @return string
     *
     * @SuppressWarnings(PHPCPD)
     */
    public function getTemplateName()
    {
        return $this->template;
    }
}
