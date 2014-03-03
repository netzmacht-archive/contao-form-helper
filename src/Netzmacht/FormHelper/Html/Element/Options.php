<?php

namespace Netzmacht\FormHelper\Html\Element;


abstract class Options extends Node
{

	/**
	 * @var string
	 */
	const CONTAINER_TAG = 'div';

	/**
	 * @var
	 */
	protected $value;

	/**
	 * @var
	 */
	protected $options;


	/**
	 * @param mixed $options
	 */
	public function setOptions($options)
	{
		$this->options = $options;
		$this->children = array();

		$this->addChildren($this->buildChildren($options));
	}


	/**
	 * @return mixed
	 */
	public function getOptions()
	{
		return $this->options;
	}


	/**
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		if(!is_array($value)) {
			$value = array($value);
		}

		$this->value = $value;
	}


	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}


	/**
	 * @param array $options
	 * @return string
	 */
	abstract protected function buildChildren(array $options);

} 