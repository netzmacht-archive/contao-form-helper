<?php

namespace Netzmacht\FormHelper\Component;

use Netzmacht\FormHelper\Component;
use Netzmacht\FormHelper\TemplateInterface;

class TemplateComponent extends Component implements TemplateInterface
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