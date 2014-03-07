<?php

namespace Netzmacht\FormHelper\Component;

use Netzmacht\FormHelper\GenerateInterface;

class StaticHtml implements GenerateInterface
{

	/**
	 * @var string
	 */
	protected $html;


	/**
	 * @param string $html
	 */
	public function __construct($html)
	{
		$this->html = $html;
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		return $this->html;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

} 