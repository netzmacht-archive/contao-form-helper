<?php

namespace Netzmacht\FormHelper\Event;

use Netzmacht\FormHelper\Html\Element;

class BuildElementEvent extends WidgetEvent
{

	/**
	 * @var Element $element
	 */
	protected $element;


	/**
	 * @param Element $element
	 */
	public function setElement(Element $element)
	{
		$this->element = $element;
	}


	/**
	 * @return Element mixed
	 */
	public function getElement()
	{
		return $this->element;
	}


} 