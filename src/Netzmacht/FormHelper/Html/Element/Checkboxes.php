<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 01.03.14
 * Time: 18:08
 */

namespace Netzmacht\FormHelper\Html\Element;

use Netzmacht\FormHelper\TemplateInterface;
use Netzmacht\FormHelper\Transfer\TemplateTrait;

class Checkboxes extends Options implements TemplateInterface
{
	use TemplateTrait;

	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('fieldset', $attributes);

		$this->template = 'formhelper_element_checkboxes';
	}


	/**
	 * @return string|void
	 */
	public function generate()
	{
		$template = new \FrontendTemplate($this->template);
		$template->options = $this->options;
		$template->attributes = $this->getAttributes();
		$template->tag = $this->getTag();

		return $template->parse();
	}

} 