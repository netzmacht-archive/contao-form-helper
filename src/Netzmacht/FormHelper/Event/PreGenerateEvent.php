<?php

namespace Netzmacht\FormHelper\Event;

use Netzmacht\FormHelper\Partial\Label;
use Netzmacht\FormHelper\Partial\Errors;
use Netzmacht\FormHelper\Partial\Container;

class PreGenerateEvent extends WidgetEvent
{

	/**
	 * @var Errors
	 */
	protected $errors;

	/**
	 * @var Label
	 */
	protected $label;

	/**
	 * @var Container
	 */
	protected $container;


	/**
	 * @param \Netzmacht\FormHelper\Partial\Container $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}


	/**
	 * @return \Netzmacht\FormHelper\Partial\Container
	 */
	public function getContainer()
	{
		return $this->container;
	}


	/**
	 * @param \Netzmacht\FormHelper\Partial\Errors $errors
	 */
	public function setErrors($errors)
	{
		$this->errors = $errors;
	}


	/**
	 * @return \Netzmacht\FormHelper\Partial\Errors
	 */
	public function getErrors()
	{
		return $this->errors;
	}


	/**
	 * @param \Netzmacht\FormHelper\Partial\Label $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return \Netzmacht\FormHelper\Partial\Label
	 */
	public function getLabel()
	{
		return $this->label;
	}

} 