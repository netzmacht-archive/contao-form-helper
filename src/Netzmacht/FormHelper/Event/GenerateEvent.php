<?php

namespace Netzmacht\FormHelper\Event;


use Netzmacht\Contao\FormHelper\Event\PreGenerateEvent;

class GenerateEvent extends PreGenerateEvent
{

	/**
	 * @var bool
	 */
	protected $visible = true;


	/**
	 * @param boolean $visible
	 */
	public function setVisible($visible)
	{
		$this->visible = (bool) $visible;
		return;
	}


	/**
	 * @return bool
	 */
	public function isVisible()
	{
		return $this->visible;
	}

} 