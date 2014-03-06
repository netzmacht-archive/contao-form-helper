<?php

namespace Netzmacht\FormHelper\Event;

use Netzmacht\FormHelper\Component\Label;
use Netzmacht\FormHelper\Component\Errors;
use Netzmacht\FormHelper\Component\Container;

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
	 * @param \Netzmacht\FormHelper\Component\Container $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}


	/**
	 * @return \Netzmacht\FormHelper\Component\Container
	 */
	public function getContainer()
	{
		return $this->container;
	}


	/**
	 * @param \Netzmacht\FormHelper\Component\Errors $errors
	 */
	public function setErrors($errors)
	{
		$this->errors = $errors;
	}


	/**
	 * @return \Netzmacht\FormHelper\Component\Errors
	 */
	public function getErrors()
	{
		return $this->errors;
	}


	/**
	 * @param \Netzmacht\FormHelper\Component\Label $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return \Netzmacht\FormHelper\Component\Label
	 */
	public function getLabel()
	{
		return $this->label;
	}

} 