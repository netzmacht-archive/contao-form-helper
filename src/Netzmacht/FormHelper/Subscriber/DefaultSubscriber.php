<?php

namespace Netzmacht\FormHelper\Subscriber;

use Netzmacht\FormHelper\Event\CreateElementEvent;
use Netzmacht\FormHelper\Event\Events;
use Netzmacht\FormHelper\Event\GenerateEvent;
use Netzmacht\FormHelper\Event\SelectLayoutEvent;
use Netzmacht\FormHelper\Html\Element;
use Netzmacht\FormHelper\Transfer\Label;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DefaultSubscriber implements EventSubscriberInterface
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
		'param'
	);

	/**
	 * @var array
	 */
	protected $noLabel = array('html', 'explanation', 'headline');

	/**
	 * @var
	 */
	protected $form;

	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * The array keys are event names and the value can be:
	 *
	 *  * The method name to call (priority defaults to 0)
	 *  * An array composed of the method name to call and the priorityGenerateEvent
	 *  * An array of arrays composed of the method names to call and respective
	 *    priorities, or 0 if unset
	 *
	 * For instance:
	 *
	 *  * array('eventName' => 'methodName')
	 *  * array('eventName' => array('methodName', $priority))
	 *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
	 *
	 * @return array The event names to listen to
	 *
	 * @api
	 */
	public static function getSubscribedEvents()
	{
		return array(
			Events::SELECT_LAYOUT             => array('selectLayout', 1000),
			Events::BUILD_ELEMENT             => array('buildElement', 1000),
			Events::PRE_GENERATE              => array('setDefaults', 1000),
			Events::GENERATE                  => array('generateCaptcha', 1000),
			Events::CREATE_ELEMENT            => array('createElement', -1000),
		);
	}


	/**
	 * @param CreateElementEvent $event
	 */
	public function createElement(CreateElementEvent $event)
	{
		// only create if no element is set
		if($event->getElement()) {
			return;
		}

		$tag        = $event->getTag();
		$attributes = $event->getAttributes();


		if(in_array($tag, static::$standalone)) {
			$element = new Element\Standalone($tag, $attributes);
		}

		elseif($tag == 'select') {
			$element = new Element\Select($attributes);
		}

		elseif($tag == 'checkboxes') {
			$element = new Element\Checkboxes($attributes);
		}

		elseif($tag == 'radios') {
			$element = new Element\Radios($attributes);
		}

		else {
			$element = new Element\Node($tag, $attributes);
		}

		$event->setElement($element);
	}


	/**
	 * @param SelectLayoutEvent $event
	 */
	public function selectLayout(SelectLayoutEvent $event)
	{
		$widget = $event->getWidget();
		$form   = $event->getForm();

		if($form && $form->tableless) {
			$event->setLayout('tableless');
		}
		else {
			$noColumns = array('explanation', 'html', 'headline');
			if(in_array($widget->type, $noColumns)) {
				$event->setLayout('table_nocolumns');
			}
			else {
				$event->setLayout('table');
			}
		}
	}


	/**
	 * @param GenerateEvent $event
	 */
	public function buildElement(GenerateEvent $event)
	{
		$widget    = $event->getWidget();
		$container = $event->getContainer();
		$element   = null;

		switch($widget->type) {
			case 'explanation':
			case 'headline':
				$element = Element::createElement('div');
				$element->addChild($widget->text);
				break;

			case 'html':
				$element = Element::createElement('div');
				$element->addChild($widget->html);
				break;

			case 'checkbox':
				$element = Element::createElement('checkboxes');
				$element->setAttribute('name', $widget->name);
				break;

			case 'radio':
				$element = Element::createElement('radios');
				$element->setAttribute('name', $widget->name);
				break;

			case 'captcha':
				$element = Element::createElement('input', array('type' => 'text'));
				$element->setAttribute('name', $widget->name);
				break;

			case 'upload':
				$element = Element::createElement('input', array('type' => 'file'));
				$element->setAttribute('name', $widget->name);
				break;

			case 'text':
			case 'submit':
				$element = Element::createElement('input', array('type' => $widget->type));
				$element->setAttribute('name', $widget->name);
				break;

			case 'textarea':
			case 'select':
				$element = Element::createElement($widget->type);
				$element->setAttribute('name', $widget->name);
				break;

			default:
				return;
		}

		$container->setElement($element);
	}


	/**
	 * @param GenerateEvent $event
	 */
	public function setDefaults(GenerateEvent $event)
	{
		$widget    = $event->getWidget();
		$container = $event->getContainer();
		$element   = $container->getElement();
		$label     = $event->getLabel();

		$this->presetLabel($label, $widget);

		if($element) {
			$element->setId('ctrl_' . $widget->id);
			$element->addClass($widget->type);

			$label->setAttribute('for', $element->getId());
			$this->presetAttributes($element, $widget);

			if($element instanceof Element\Options && $widget->options) {
				$this->presetOptions($element, $widget);
			}

			if($widget->type == 'submit') {
				$this->presetSubmit($element, $widget);
			}
		}

		if($widget->addSubmit && $widget->type != 'submit') {

			$submit = Element::createElement('input');
			$submit->setAttribute('type', 'submit');
			$submit->setAttribute('value', $widget->slabel);

			$container->add('submit', $submit);
		}
	}


	/**
	 * @param GenerateEvent $event
	 */
	public function generateCaptcha(GenerateEvent $event)
	{
		$widget = $event->getWidget();
		$container = $event->getContainer();

		if($widget->type == 'captcha') {
			/** @var \FormCaptcha $widget */
			$question = $widget->generateQuestion();
			$container->add('question', $question);
		}
	}


	/**
	 * @param Label $label
	 * @param \Widget $widget
	 */
	protected function presetLabel(Label $label, \Widget $widget)
	{
		if($widget->label) {
			$label->addChild($widget->label);
		}

		if($widget->mandatory) {
			$mandatory = $label->createElement('span', array('class' => array('mandatory')));
			$mandatory->addChild(sprintf('<span class="invisible">%s</span>', $GLOBALS['TL_LANG']['MSC']['mandatory']));
			$mandatory->addChild('*');

			$label->addChild($mandatory);
		}

		if(in_array($widget->type, $this->noLabel)) {
			$label->hide();
		}
	}


	/**
	 * @param Element $element
	 * @param \Widget $widget
	 */
	protected function presetSubmit(Element $element, \Widget $widget)
	{
		$element->setAttribute('value', $widget->slabel);

		if($widget->imageSubmit) {
			$element->setAttribute('type', 'image');

			if(version_compare(VERSION, '3', '>=')) {
				$path = \FilesModel::findByPk($widget->singleSRC)->path;
			}
			else {
				$path = $widget->singleSRC;
			}

			$element->setAttribute('src', $path);
			$element->setAttribute('title', $widget->slabel);
		}
	}


	/**
	 * @param Element $element
	 * @param \Widget $widget
	 */
	protected function presetAttributes(Element $element, \Widget $widget)
	{
		if($widget->class) {
			$classes = trimsplit(' ', $widget->class);

			foreach($classes as $class) {
				$element->addClass($class);
			}
		}

		if($widget->value) {
			if($element->getTag() == 'textarea' && $element instanceof Element\Node) {
				$element->addChild($widget->value);
			}
			elseif($element->getTag() == 'input') {
				$element->setAttribute('value', $widget->value);
			}
		}

		if($widget->mandatory) {
			$element->setAttribute('required', true);
		}

		$transform = array('tabindex', 'accesskey', 'maxlength', 'placeholder', 'value', 'size');

		foreach($transform as $attribute) {
			if($widget->$attribute) {
				$element->setAttribute($attribute, $widget->$attribute);
			}
		}

	}


	/**
	 * @param Element\Options $element
	 * @param \Widget $widget
	 */
	protected function presetOptions(Element\Options $element, \Widget $widget)
	{
		$element->setValue($widget->value);
		$element->setOptions($widget->options);
	}

} 