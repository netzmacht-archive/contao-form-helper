<?php

namespace Netzmacht\FormHelper\Partial;

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
	function __construct(array $errors, array $attributes=array())
	{
		parent::__construct($attributes);

		$this->errors     = $errors;
		$this->template   = 'formhelper_error_last';
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
		if(isset($this->errors[0])) {
			return $this->errors[0];
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
		$template->errors = $this->errors;
		$template->attributes = $this->attributes;

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