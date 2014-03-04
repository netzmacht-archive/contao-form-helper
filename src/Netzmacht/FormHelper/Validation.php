<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 04.03.14
 * Time: 15:32
 */

namespace Netzmacht\FormHelper;


use Netzmacht\FormHelper\Event\Events;
use Netzmacht\FormHelper\Event\ValidateFormFieldEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Validation
{

	/**
	 * @var FormLocator
	 */
	protected $formLocator;

	/**
	 * @var EventDispatcherInterface
	 */
	protected $dispatcher;


	/**
	 * @param EventDispatcherInterface $dispatcher
	 * @param FormLocator $formLocator
	 */
	function __construct(EventDispatcherInterface $dispatcher, FormLocator $formLocator)
	{
		$this->formLocator = $formLocator;
		$this->dispatcher  = $dispatcher;
	}


	/**
	 * @return Validation
	 */
	public function getInstance()
	{
		return $GLOBALS['container']['form-helper.validation'];
	}


	/**
	 * @param \Widget $widget
	 * @param $id
	 * @return \Widget
	 */
	public function validateFormField(\Widget $widget, $id)
	{
		$form  = $this->formLocator->getForm($widget->pid);
		$event = new ValidateFormFieldEvent($widget, $form);
		$event->setId($id);

		$this->dispatcher->dispatch(Events::VALIDATE, $event);

		return $event->getWidget();
	}

} 