<?php

namespace Netzmacht\FormHelper\Html;

use Netzmacht\FormHelper\Event\CreateElementEvent;
use Netzmacht\FormHelper\Event\Events;
use Netzmacht\FormHelper\GenerateInterface;
use Netzmacht\FormHelper\Html\Element\Node;
use Netzmacht\FormHelper\Html\Element\Standalone;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 * Class Node
 * @package Netzmacht\FormHelper\Html
 */
abstract class Element implements GenerateInterface
{

	/**
	 * @var Attributes
	 */
	protected $attributes;

	/**
	 * @var string
	 */
	protected $tag;


	/**
	 * @param string $tag
	 * @param array $attributes
	 */
	function __construct($tag, $attributes=array())
	{
		$default = array(
			'class' => array()
		);

		$attributes = array_merge($default, $attributes);

		$this->attributes = new Attributes($attributes);
		$this->tag = $tag;
	}


	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}


	/**
	 * @param $tag
	 * @param array $attributes
	 * @return Standalone|Node
	 */
	public static function createElement($tag, array $attributes=array())
	{
		/** @var EventDispatcherInterface $dispatcher */
		$dispatcher = $GLOBALS['container']['event-dispatcher'];

		$event = new CreateElementEvent($tag, $attributes);
		$dispatcher->dispatch(Events::CREATE_ELEMENT, $event);

		return $event->getElement();
	}


	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function setAttributes($attributes)
	{
		$this->attributes->add($attributes);
		return $this;
	}


	/**
	 * @return Attributes
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}


	/**
	 * @param $name
	 * @param $value
	 * @return $this
	 */
	public function setAttribute($name, $value)
	{
		$this->attributes->set($name, $value);

		return $this;
	}


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAttribute($name, $default=null)
	{
		return $this->attributes->get($name, $default);
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function hasAttribute($name)
	{
		return $this->attributes->has($name);
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function removeAttribute($name)
	{
		$this->attributes->remove($name);

		return $this;
	}


	/**
	 * @param $value
	 * @return $this
	 */
	public function setId($value)
	{
		$this->setAttribute('id', $value);

		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->getAttribute('id');
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function hasClass($name)
	{
		$classes = $this->getAttribute('class');

		return in_array($name, $classes);
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function addClass($name)
	{
		if(!$this->hasClass($name)) {
			$classes = $this->getAttribute('class');
			$classes[] = $name;

			$this->setAttribute('class', $classes);
		}

		return $this;
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function removeClass($name)
	{
		if($this->hasClass($name)) {
			$classes = $this->getAttribute('class');
			$index = array_search($name, $classes);
			unset($classes[$index]);

			$this->setAttribute('class', array_values($classes));
		}

		return $this;
	}


	/**
	 * @return string
	 */
	abstract public function generate();


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

} 