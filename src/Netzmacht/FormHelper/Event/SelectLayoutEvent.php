<?php

namespace Netzmacht\FormHelper\Event;

class SelectLayoutEvent extends WidgetEvent
{

	/**
	 * @var string
	 */
	protected $layout = '';


	/**
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}


	/**
	 * @return string
	 */
	public function getLayout()
	{
		return $this->layout;
	}

} 