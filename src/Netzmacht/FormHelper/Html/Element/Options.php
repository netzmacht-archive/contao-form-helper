<?php

namespace Netzmacht\FormHelper\Html\Element;

use Netzmacht\FormHelper\Html\Element;
use Netzmacht\FormHelper\TemplateInterface;
use Netzmacht\FormHelper\Transfer\TemplateTrait;


abstract class Options extends Element implements TemplateInterface
{
	use TemplateTrait;

	/**
	 * @var string
	 */
	const CONTAINER_TAG = 'div';

	/**
	 * @var
	 */
	protected $value;

	/**
	 * @var
	 */
	protected $options;


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

} 