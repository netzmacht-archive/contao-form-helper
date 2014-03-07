<?php

namespace Netzmacht\FormHelper;

use Netzmacht\FormHelper\Component\StaticHtml;
use Netzmacht\FormHelper\Event\BuildElementEvent;
use Netzmacht\FormHelper\Event\Events;
use Netzmacht\FormHelper\Event\GenerateEvent;
use Netzmacht\FormHelper\Event\PreGenerateEvent;
use Netzmacht\FormHelper\Event\SelectLayoutEvent;
use Netzmacht\FormHelper\Event\SelectMessageLayoutEvent;
use Netzmacht\FormHelper\Component\Container;
use Netzmacht\FormHelper\Component\Errors;
use Netzmacht\FormHelper\Component\Label;
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
		$container = new Container();
		$errors    = new Errors($widget->getErrors());

		// build element event
		$event = new BuildElementEvent($widget, $form);
		$this->dispatcher->dispatch(Events::BUILD_ELEMENT, $event);

		$element = $event->getElement();

		// no element given by build event. generate form widget instead
		if(!$element) {
			$element = new StaticHtml($widget->generate());
		}

		$container->setElement($element);

		// pre generate
		$event = new PreGenerateEvent($widget, $form);
		$event->setLabel($label);
		$event->setErrors($errors);
		$event->setContainer($container);

		$this->dispatcher->dispatch(Events::PRE_GENERATE, $event);

		// generate
		$event = new GenerateEvent($widget, $form);
		$event->setLabel($label);
		$event->setErrors($errors);
		$event->setContainer($container);

		$this->dispatcher->dispatch(Events::GENERATE, $event);

		if($event->isVisible()) {
			return array($label, $container, $errors);
		}

		return false;
	}

}