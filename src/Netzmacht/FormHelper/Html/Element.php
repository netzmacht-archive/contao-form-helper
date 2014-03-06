<?php

namespace Netzmacht\FormHelper\Html;

use Netzmacht\FormHelper\Component;
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
abstract class Element extends Component implements GenerateInterface
{
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
		parent::__construct($attributes);

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
	public static function create($tag, array $attributes=array())
	{
		/** @var EventDispatcherInterface $dispatcher */
		$dispatcher = $GLOBALS['container']['event-dispatcher'];

		$event = new CreateElementEvent($tag, $attributes);
		$dispatcher->dispatch(Events::CREATE_ELEMENT, $event);

		return $event->getElement();
	}


	/**
	 * @param Node $parent
	 * @param string $position
	 * @return $this
	 */
	public function appendTo(Node $parent, $position=Node::POSITION_LAST)
	{
		$parent->addChild($this, $position);

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