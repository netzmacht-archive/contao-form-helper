<?php

namespace Netzmacht\FormHelper\Html\Element;

class Checkboxes extends Options
{
	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('fieldset', $attributes);

		$this->template = 'formhelper_element_checkboxes';
	}

} 