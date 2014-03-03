<?php

namespace Netzmacht\FormHelper\Event;

use Netzmacht\FormHelper\Transfer\Label;
use Netzmacht\FormHelper\Transfer\Errors;
use Netzmacht\FormHelper\Transfer\Container;

class GenerateEvent extends WidgetEvent
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
	 * @param \Netzmacht\FormHelper\Transfer\Container $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}


	/**
	 * @return \Netzmacht\FormHelper\Transfer\Container
	 */
	public function getContainer()
	{
		return $this->container;
	}


	/**
	 * @param \Netzmacht\FormHelper\Transfer\Errors $errors
	 */
	public function setErrors($errors)
	{
		$this->errors = $errors;
	}


	/**
	 * @return \Netzmacht\FormHelper\Transfer\Errors
	 */
	public function getErrors()
	{
		return $this->errors;
	}


	/**
	 * @param \Netzmacht\FormHelper\Transfer\Label $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return \Netzmacht\FormHelper\Transfer\Label
	 */
	public function getLabel()
	{
		return $this->label;
	}

} 