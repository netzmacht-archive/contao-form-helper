<?php

namespace Netzmacht\FormHelper\Transfer;

trait TemplateTrait
{

	/**
	 * @var string
	 */
	protected $template;

	/**
	 * @param string $name
	 * @return $this
	 */
	public function setTemplateName($name)
	{
		$this->template = $name;
	}


	/**
	 * @return string
	 */
	public function getTemplateName()
	{
		return $this->template;
	}

} 