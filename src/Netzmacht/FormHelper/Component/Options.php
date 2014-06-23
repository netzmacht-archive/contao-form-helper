<?php

namespace Netzmacht\FormHelper\Component;

use Netzmacht\Html\Element;
use Netzmacht\FormHelper\TemplateInterface;


abstract class Options extends Element implements TemplateInterface
{

	/**
	 * @var string
	 */
	const CONTAINER_TAG = 'div';

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @var string
	 */
	protected $template;


	/**
	 * @param mixed $options
	 */
	public function setOptions($options)
	{
		$this->options = $options;
		$this->children = array();
	}


	/**
	 * @return mixed
	 */
	public function getOptions()
	{
		return $this->options;
	}


	/**
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		if(!is_array($value)) {
			$value = array($value);
		}

		$this->value = $value;
	}


	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}


	/**
	 * @return string|void
	 */
	public function generate()
	{
		$template             = new \FrontendTemplate($this->template);
		$template->options    = $this->options;
		$template->attributes = $this->getAttributes();
		$template->tag        = $this->getTag();

		return $template->parse();
	}


	/**
	 * @param string $name
	 * @return $this
	 */
	public function setTemplateName($name)
	{
		$this->template = $name;

		return $this->template;
	}


	/**
	 * @return string
	 */
	public function getTemplateName()
	{
		return $this->template;
	}

} 