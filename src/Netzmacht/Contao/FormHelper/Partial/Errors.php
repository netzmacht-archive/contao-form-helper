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

/**
 * Class Errors is used for render widget validation errors. It can render one or all errors.
 *
 * @package Netzmacht\Contao\FormHelper\Partial
 */
class Errors extends TemplateComponent
{
    /**
     * The validation errors.
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Construct.
     *
     * @param array $errors     The validation errors.
     * @param array $attributes Default html attributes.
     */
    public function __construct(array $errors, array $attributes = array())
    {
        parent::__construct($attributes);

        $this->errors   = $errors;
        $this->template = 'formhelper_error_last';
    }

    /**
     * Get all errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get an error by the defined position.
     *
     * @param int $index The index of the error.
     *
     * @return string
     */
    public function getError($index = 0)
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }

        return '';
    }

    /**
     * Consider if any errors are set.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Generate the component.
     *
     * @return string
     */
    public function generate()
    {
        $template         = new \FrontendTemplate($this->template);
        $template->errors = $this;

        return $template->parse();
    }

    /**
     * Casts to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->generate();
    }
}
