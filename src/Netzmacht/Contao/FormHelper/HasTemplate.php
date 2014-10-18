<?php

namespace Netzmacht\Contao\FormHelper;


interface HasTemplate
{

	/**
	 * @param string $name
	 * @return $this
	 */
	public function setTemplateName($name);


	/**
	 * @return string
	 */
	public function getTemplateName();

} 