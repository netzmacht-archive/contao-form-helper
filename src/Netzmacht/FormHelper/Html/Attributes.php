<?php

namespace Netzmacht\FormHelper\Html;


use Netzmacht\FormHelper\GenerateInterface;
use Traversable;

/**
 * Class Attributes
 * @package Netzmacht\FormHelper\Html
 */
class Attributes implements GenerateInterface, \IteratorAggregate
{

	/**
	 * All standalone elements
	 * @var array
	 */
	protected static $standalone = array(
		'area',
		'base',
		'basefont',
		'br',
		'col',
		'frame',
		'hr',
		'img',
		'input',
		'isindex',
		'link',
		'meta',
		'novalidate',
		'param'
	);

	/**
	 * @var array
	 */
	protected $attributes;


	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes=array())
	{
		$this->attributes = $attributes;
	}


	/**
	 * @param $name
	 * @param $value
	 * @return $this
	 */
	public function set($name, $value)
	{
		$this->attributes[$name] = $value;

		return $this;
	}


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function get($name, $default=null)
	{
		if($this->has($name)) {
			return $this->attributes[$name];
		}

		return $default;
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function has($name)
	{
		return isset($this->attributes[$name]);
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function remove($name)
	{
		unset($this->attributes[$name]);

		return $this;
	}


	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function add(array $attributes)
	{
		foreach($attributes as $name => $value) {
			$this->set($name, $value);
		}

		return $this;
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->attributes);
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		$buffer   = '';
		$template = ' %s="%s"';

		foreach($this->attributes as $name => $value) {
			switch($name) {
				case 'compact':
				case 'declare':
				case 'defer':
				case 'disabled':
				case 'ismap':
				case 'readonly':
				case 'required':
				case 'selected':
				case 'multiple':
				case 'nowrap':
					if($value) {
						$buffer .= ' ' . $name;
					}

					break;

				case 'class':
					if(!empty($value)) {
						$value = array_map('specialchars', $value);
						$value = implode(' ', $value);

						$buffer .= sprintf($template, $name, $value);
					}

					break;

				default:
					if(!is_array($value)) {
						$buffer .= sprintf($template, $name, specialchars($value));
					}

					break;
			}
		}

		return trim($buffer);
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

}