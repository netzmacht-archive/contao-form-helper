<?php

namespace Netzmacht\Contao\FormHelper\Element;


class Radios extends Options implements HasLabel
{
	/**
	 * @var Label|string
	 */
	private $label;


	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('fieldset', $attributes);

		$this->template = 'formhelper_element_radios';
	}


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