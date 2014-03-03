<?php

namespace Netzmacht\FormHelper\Transfer;

use Netzmacht\FormHelper\GenerateInterface;
use Netzmacht\FormHelper\Html\Attributes;
use Netzmacht\FormHelper\Html\Element;
use Netzmacht\FormHelper\Html\Element\Node;
use Netzmacht\FormHelper\TemplateInterface;

class Container implements GenerateInterface, TemplateInterface
{
	use TemplateTrait;

	const POSITION_BEFORE = 'before';
	const POSITION_AFTER = 'after';
	const POSITION_WRAPPER = 'wrapper';
	const POSITION_LAST = 'last';
	const POSITION_FIRST = 'first';

	/**
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * @var Element
	 */
	protected $element;

	/**
	 * @var array
	 */
	protected $children;

	/**
	 * @var array
	 */
	protected $names = array();

	/**
	 * @var
	 */
	protected $elementTemplate = 'formhelper_element_default';


	/**
	 * @param Attributes $attributes
	 */
	function __construct(Attributes $attributes)
	{
		$this->template   = 'formhelper_element_container';
		$this->attributes = $attributes;
		$this->children   = array(
			static::POSITION_AFTER => array(),
			static::POSITION_BEFORE => array(),
			static::POSITION_WRAPPER => array(),
		);
	}


	/**
	 * @return \Netzmacht\FormHelper\Html\Attributes
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}


	/**
	 * @return array
	 */
	public function getChildren()
	{
		return $this->children;
	}


	/**
	 * @param \Netzmacht\FormHelper\Html\Element $element
	 */
	public function setElement($element)
	{
		$this->element = $element;
	}


	/**
	 * @return \Netzmacht\FormHelper\Html\Element
	 */
	public function getElement()
	{
		return $this->element;
	}


	/**
	 * @param mixed $elementTemplate
	 */
	public function setElementTemplateName($elementTemplate)
	{
		$this->elementTemplate = $elementTemplate;
	}


	/**
	 * @return mixed
	 */
	public function getElementTemplateName()
	{
		return $this->elementTemplate;
	}


	/**
	 * @param string $name
	 * @param GenerateInterface|string $child
	 * @param string $position
	 * @param string $childPosition
	 * @return $this
	 * @throws
	 */
	public function add($name, $child, $position=Container::POSITION_AFTER, $childPosition=Container::POSITION_LAST)
	{
		if($this->has($name)) {
			throw new \Exception(sprintf('Duplicate child name "%s" given.', $name));
		}

		$children = &$this->children[$position];

		if(is_int($childPosition)) {
			array_insert($children, $childPosition, array($child));
		}
		elseif($childPosition == static::POSITION_FIRST) {
			array_unshift($children, $child);
		}
		else {
			$children[] = $child;
		}

		return $this;
	}


	/**
	 * @param $name
	 * @return GenerateInterface|string
	 * @throws
	 */
	public function get($name)
	{
		if($this->has($name)) {
			foreach($this->children as $children) {
				foreach($children as $index => $child) {
					if($index == $name) {
						return $child;
					}
				}
			}
		}

		throw new \Exception(sprintf('Unkown child with name "%s"', $name));
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function remove($name)
	{
		if($this->has($name)) {
			foreach($this->children as $position => $children) {
				foreach($children as $index => $child) {
					unset($this->children[$position][$index]);
					break 2;
				}
			}
		}

		return $this;
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function has($name)
	{
		return in_array($name, $this->names);
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		$template = new \FrontendTemplate($this->template);
		$template->before = $this->children[static::POSITION_BEFORE];
		$template->wrappers = $this->children[static::POSITION_WRAPPER];
		$template->after = $this->children[static::POSITION_AFTER];
		$template->container = $this;

		return $template->parse();
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}


	/**
	 * @return string
	 */
	public function generateElement()
	{
		$template = new \FrontendTemplate($this->elementTemplate);
		$template->element = $this->element;

		return $template->parse();
	}


	/**
	 * @param string|GenerateInterface $child
	 * @return string;
	 */
	public function generateChild($child)
	{
		if(is_string($child)) {
			return $child;
		}

		try {
			return (string) $child;
		}
		catch(\Exception $e) {
			// TODO: How to handle exception
		}

		return '';
	}


	/**
	 * @param $wrapper
	 * @param $element
	 * @return string
	 */
	public function generateWrapper($wrapper, $element)
	{
		if($wrapper instanceof Node) {
			$tmp = clone $wrapper;
			$tmp->addChild($element);

			return $tmp->generate();
		}
		elseif(is_string($wrapper) && strpos($wrapper, '%s') !== false) {
			return sprintf($wrapper, $element);
		}

		// TODO: Should an exception be thrown here?
		return $element;
	}

}