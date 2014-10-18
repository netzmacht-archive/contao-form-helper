<?php

namespace Netzmacht\Contao\FormHelper\Partial;

class Errors extends TemplateComponent
{

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @param array $errors
     * @param array $attributes
     */
    public function __construct(array $errors, array $attributes=array())
    {
        parent::__construct($attributes);

        $this->errors   = $errors;
        $this->template = 'formhelper_error_last';
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $index
     * @return string
     */
    public function getError($index=0)
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }

        return '';
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * @return string
     */
    public function generate()
    {
        $template = new \FrontendTemplate($this->template);
        $template->errors = $this;

        return $template->parse();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->generate();
    }

}
