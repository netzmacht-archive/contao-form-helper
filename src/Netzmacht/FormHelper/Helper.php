<?php

namespace Netzmacht\FormHelper;

use Netzmacht\FormHelper\Event\Events;
use Netzmacht\FormHelper\Event\GenerateEvent;
use Netzmacht\FormHelper\Event\SelectLayoutEvent;
use Netzmacht\FormHelper\Event\SelectMessageLayoutEvent;
use Netzmacht\FormHelper\Html\Attributes;
use Netzmacht\FormHelper\Transfer\Container;
use Netzmacht\FormHelper\Transfer\Errors;
use Netzmacht\FormHelper\Transfer\Label;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Helper
{

	/**
	 * @var Helper
	 */
	protected static $instance;

	/**
	 * @var EventDispatcherInterface
	 */
	protected $dispatcher;

	/**
	 * @var FormLocator
	 */
	protected $forms;


	/**
	 * @param EventDispatcherInterface $dispatcher
	 * @param $forms
	 */
	function __construct(EventDispatcherInterface $dispatcher, FormLocator $forms)
	{
		$this->dispatcher = $dispatcher;
		$this->forms      = $forms;
	}


	/**
	 * @return Helper
	 */
	public static function getInstance()
	{
		return $GLOBALS['container']['form-helper'];
	}


	/**
	 * @param \Widget $widget
	 * @return string
	 */
	public function getLayout(\Widget $widget)
	{
		$form  = $this->forms->getForm($widget->pid);
		$event = new SelectLayoutEvent($widget, $form);
		$this->dispatcher->dispatch(Events::SELECT_LAYOUT, $event);

		$layout = 'formhelper_layout_' . $event->getLayout();
		return \Controller::getTemplate($layout);
	}


	/**
	 * @param \Template $template
	 * @return string
	 */
	public function getMessageLayout(\Template $template)
	{
		$event = new SelectMessageLayoutEvent($template);
		$event->setLayout('default');

		$this->dispatcher->dispatch(Events::SELECT_MESSAGE_LAYOUT, $event);

		return 'formhelper_message_' . $event->getLayout();
	}


	/**
	 * @param \Widget $widget
	 * @return array|false
	 */
	public function generate(\Widget $widget)
	{
		$form      = $this->forms->getForm($widget->pid);
		$label     = new Label();
		$container = new Container(new Attributes());
		$errors    = new Errors($widget->getErrors(), new Attributes());

		$events = array(Events::BUILD_ELEMENT, Events::PRE_GENERATE, Events::GENERATE);
		$visible = true;

		foreach($events as $eventName) {
			$event = new GenerateEvent($widget, $form);
			$event->setLabel($label);
			$event->setErrors($errors);
			$event->setContainer($container);
			$event->setVisible($visible);

			$this->dispatcher->dispatch($eventName, $event);
			$visible = $event->isVisible();
		}

		if($visible) {
			return array($label, $container, $errors);
		}

		return false;
	}

}