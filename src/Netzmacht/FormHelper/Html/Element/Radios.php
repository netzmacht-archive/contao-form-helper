<?php

namespace Netzmacht\FormHelper\Html\Element;


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