<?php

namespace Netzmacht\Contao\FormHelper\Element;

use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;

class StaticHtml implements CastsToString, CanBeAppended
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
	 * @param Node $parent
	 * @param string $position
	 * @return $this
	 */
	public function appendTo(Node $parent, $position = Node::POSITION_LAST)
	{
		$parent->addChild($this, $position);

		return $this;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

} 