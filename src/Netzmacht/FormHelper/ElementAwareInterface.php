<?php

namespace Netzmacht\FormHelper;


interface ElementAwareInterface
{

	/**
	 * @param GenerateInterface|string $element
	 * @return $this
	 */
	public function setElement($element);


	/**
	 * @return GenerateInterface|string
	 */
	public function getElement();

} 