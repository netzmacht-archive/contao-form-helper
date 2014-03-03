<?php

namespace Netzmacht\FormHelper\Html\Element;


use Netzmacht\FormHelper\Html\Element;

class Standalone extends Element
{

	/**
	 * @return string
	 */
	public function generate()
	{
		return sprintf(
			'<%s %s>',
			$this->tag,
			$this->attributes->generate()
		);
	}

} 