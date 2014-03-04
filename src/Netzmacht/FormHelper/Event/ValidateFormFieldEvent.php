<?php

namespace Netzmacht\FormHelper\Event;


class ValidateFormFieldEvent extends WidgetEvent
{

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @param $error
	 */
	public function addError($error)
	{
		$this->widget->addError($error);
	}

} 