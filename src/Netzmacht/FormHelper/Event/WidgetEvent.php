<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 28.02.14
 * Time: 16:49
 */

namespace Netzmacht\FormHelper\Event;

use Symfony\Component\EventDispatcher\Event;
use Widget;

/**
 * Class FormWidgetEvent
 * @package Netzmacht\Bootstrap\Form\Event
 */
class WidgetEvent extends Event
{

	/**
	 * @var Widget
	 */
	protected $widget;

	/**
	 * @var \Database\Result
	 */
	protected $form;


	/**
	 * @param Widget $widget
	 * @param \Database\Result|null $form
	 */
	function __construct(Widget $widget, $form=null)
	{
		$this->widget = $widget;
		$this->form   = $form;
	}


	/**
	 * @return \Widget
	 */
	public function getWidget()
	{
		return $this->widget;
	}


	/**
	 * @param \Database\Result $form
	 */
	public function setForm($form)
	{
		$this->form = $form;
	}


	/**
	 * @return \Database\Result
	 */
	public function getForm()
	{
		return $this->form;
	}

} 