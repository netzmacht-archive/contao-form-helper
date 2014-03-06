<?php

namespace Netzmacht\FormHelper\Html\Element;

use Netzmacht\FormHelper\GenerateInterface;
use Netzmacht\FormHelper\Html\Element;

class Node extends Element
{
	const POSITION_FIRST = 'first';
	const POSITION_LAST = 'last';

	/**
	 * @var array
	 */
	protected $children = array();


	/**
	 * @param Element|string $child
	 * @param $position
	 * @return $this
	 */
	public function addChild($child, $position=Node::POSITION_LAST)
	{
		if(is_int($position)) {
			array_insert($this->children, $position, array($child));
		}
		elseif($position == static::POSITION_FIRST) {
			array_unshift($this->children, $child);
		}
		else {
			$this->children[] = $child;
		}

		return $this;
	}


	/**
	 * @param array $children
	 * @return $this
	 */
	public function addChildren(array $children)
	{
		foreach($children as $child) {
			$this->addChild($child);
		}

		return $this;
	}


	/**
	 * @param Element $child
	 * @return $this
	 */
	public function removeChild(Element $child)
	{
		$key = array_search($child, $this->children);

		if($key !== false) {
			unset($this->children[$key]);
			$this->children = array_values($this->children);
		}

		return $this;
	}


	/**
	 * @param $child
	 * @return int|false
	 */
	public function getChildPosition($child)
	{
		return array_search($child, $this->children);
	}


	/**
	 * @param $tag
	 * @param array $attributes
	 * @param string $position
	 * @return Node|Standalone
	 */
	public function createChild($tag, $attributes=array(), $position=Node::POSITION_LAST)
	{
		$child = Element::create($tag, $attributes);
		$this->addChild($child, $position);

		return $child;
	}


	/**
	 * @return array
	 */
	public function getChildren()
	{
		return $this->children;
	}


	/**
	 * @return string
	 */
	public function generateChildren()
	{
		$buffer = '';

		foreach($this->children as $child) {
			if(is_string($child)) {
				$buffer .= $child;
			}
			elseif(is_object($child) && $child instanceof GenerateInterface) {
				$buffer .= $child->generate();
			}
			else {
				try {
					$buffer .= (string) $child;
				}
				catch(\Exception $e) {}
			}
		}

		return $buffer;
	}


	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->generateChildren();
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		return sprintf(
			'<%s %s>%s</%s>',
			$this->tag,
			$this->attributes->generate(),
			$this->generateChildren(),
			$this->tag
		);
	}

}