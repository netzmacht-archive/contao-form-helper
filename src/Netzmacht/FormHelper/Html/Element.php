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
	use AttributesTrait;

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