<?php

namespace Netzmacht\FormHelper\Html\Element;


class Radios extends Options
{

	/**
	 * @param array $attributes
	 */
	function __construct($attributes = array())
	{
		parent::__construct('fieldset', $attributes);
	}

	/**
	 * @param array $options
	 * @return array
	 */
	protected function buildChildren(array $options)
	{
		$children = array();
		$group = $this;
		$index = 0;

		foreach($options as $name => $value) {
			// group
			if(isset($value['group']) && $value['group']) {
				$headline = $this->createElement('legend');
				$headline->addChild($value['label']);

				$group = $this->createElement('fieldset');
				$group->addClass('radio_container');
				$group->addChild($headline);

				$this->addChild($group);
			}
			else {
				$option = $this
					->createElement('input', array('type' => 'radio'))
					->setAttribute('name', $this->getAttribute('name') . '[]')
					->setId($this->getId() . '_' . $index)
					->setAttribute('value', $value['value']);

				if(in_array($value['value'], $this->value)) {
					$option->setAttribute('checked', true);
				}

				$container = $this->createElement('span');

				$label = $this->createElement('label');
				$label->setAttribute('for', $option->getId());
				$label->addChild($value['label']);

				$container->addChild($option);
				$container->addChild(' ');
				$container->addChild($label);

				$group->addChild($container);
			}

			$index++;
		}

		return $children;
	}

} 