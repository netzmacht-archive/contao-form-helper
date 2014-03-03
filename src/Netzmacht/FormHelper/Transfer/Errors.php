<?php

namespace Netzmacht\FormHelper\Transfer;

use Netzmacht\FormHelper\GenerateInterface;
use Netzmacht\FormHelper\Html\Attributes;
use Netzmacht\FormHelper\TemplateInterface;

class Errors implements GenerateInterface, TemplateInterface
{

	/**
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * @var array
	 */
	protected $errors = array();

	/**
	 * @var string
	 */
	protected $template = 'formhelper_error_last';


	/**
	 * @param array $errors
	 * @param Attributes $attributes
	 */
	function __construct(array $errors, Attributes $attributes)
	{
		$this->errors     = $errors;
		$this->attributes = $attributes;
	}

	/**
	 * @return \Netzmacht\FormHelper\Html\Attributes
	 */
	public function getAttributes()
	{
		return $this->attributes;
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
	 * @param string $template
	 */
	public function setTemplateName($template)
	{
		$this->template = $template;
	}


	/**
	 * @return string
	 */
	public function getTemplateName()
	{
		return $this->template;
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