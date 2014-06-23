<?php


namespace Netzmacht\FormHelper\Component;


class Select extends Options
{

	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('select', $attributes);

		$this->template = 'formhelper_element_select';
	}

} 