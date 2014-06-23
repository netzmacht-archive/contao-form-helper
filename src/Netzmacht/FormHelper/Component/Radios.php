<?php

namespace Netzmacht\FormHelper\Component;


class Radios extends Options
{
	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('fieldset', $attributes);

		$this->template = 'formhelper_element_radios';
	}

} 