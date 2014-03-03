<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 01.03.14
 * Time: 17:57
 */

namespace Netzmacht\FormHelper\Html\Element;


class Select extends Options
{
	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('select', $attributes);
	}


	/**
	 * @param array $options
	 * @return string
	 */
	protected function buildChildren(array $options)
	{
		$children = array();
		$index = 0;
		$group = $this;

		foreach($options as $value) {
			$index++;
			// optgroup
			if(isset($value['group']) && $value['group']) {
				$group = $this->createElement('optgroup');
				$group->setAttribute('label', $value['label']);

				$this->addChild($group);
			}
			else {
				$option = $this->createElement('option', array('value' => $value['value']));
				$option->addChild($value['label']);

				if(in_array($value, $this->value)) {
					$option->setAttribute('selected', true);
				}

				$group->addChild($option);
			}
		}

		return $children;
	}
} 