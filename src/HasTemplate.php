<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper;

/**
 * Interface HasTemplate describes elements which can be rendered using a template.
 *
 * @package Netzmacht\Contao\FormHelper
 */
interface HasTemplate
{
    /**
     * Set the template name.
     *
     * @param string $name The template name.
     *
     * @return $this
     */
    public function setTemplateName($name);

    /**
     * Get the template name.
     *
     * @return string
     */
    public function getTemplateName();
}
