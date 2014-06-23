<?php

namespace Netzmacht\FormHelper\Partial;

use Netzmacht\FormHelper\Component;
use Netzmacht\FormHelper\Partial;
use Netzmacht\FormHelper\HasTemplate;

class TemplateComponent extends Component implements HasTemplate
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