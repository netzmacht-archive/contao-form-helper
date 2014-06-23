<?php

namespace Netzmacht\FormHelper;


use Netzmacht\Html\CastsToString;

interface HasElement
{

	/**
	 * @param CastsToString|string $element
	 * @return $this
	 */
	public function setElement($element);


	/**
	 * @return CastsToString|string
	 */
	public function getElement();

} 