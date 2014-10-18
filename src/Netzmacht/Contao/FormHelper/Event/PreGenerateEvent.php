<?php

namespace Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Contao\FormHelper\Partial\Errors;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\FormHelper\Event\WidgetEvent;

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
	 * @param \Netzmacht\Contao\FormHelper\Partial\Container $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}


	/**
	 * @return \Netzmacht\Contao\FormHelper\Partial\Container
	 */
	public function getContainer()
	{
		return $this->container;
	}


	/**
	 * @param \Netzmacht\Contao\FormHelper\Partial\Errors $errors
	 */
	public function setErrors($errors)
	{
		$this->errors = $errors;
	}


	/**
	 * @return \Netzmacht\Contao\FormHelper\Partial\Errors
	 */
	public function getErrors()
	{
		return $this->errors;
	}


	/**
	 * @param \Netzmacht\Contao\FormHelper\Partial\Label $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}


	/**
	 * @return \Netzmacht\Contao\FormHelper\Partial\Label
	 */
	public function getLabel()
	{
		return $this->label;
	}

} 