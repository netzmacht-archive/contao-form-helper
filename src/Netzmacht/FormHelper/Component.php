<?php

namespace Netzmacht\FormHelper;

use Netzmacht\Html\Attributes;

class Component extends Attributes
{
	/**
	 * @var Attributes
	 */
	protected $attributes;


	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes = array())
	{
		$attributes = array_merge(array('class' => array()), $attributes);
		$this->attributes = new Attributes($attributes);
	}


	/**
	 *
	 */
	public function __clone()
	{
		$this->attributes = clone $this->attributes;
	}
} 