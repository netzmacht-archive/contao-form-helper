<?php

namespace Netzmacht\FormHelper;

use Netzmacht\Contao\FormHelper\Element\Select;
use Netzmacht\Contao\FormHelper\Element\Checkboxes;
use Netzmacht\Contao\FormHelper\Element\HasLabel;
use Netzmacht\Contao\FormHelper\Element\Options;
use Netzmacht\Contao\FormHelper\Element\Radios;
use Netzmacht\Contao\FormHelper\Element\StaticHtml;
use Netzmacht\Contao\FormHelper\Event\BuildElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\GeneratesAnElement;
use Netzmacht\FormHelper\Event\GenerateEvent;
use Netzmacht\Contao\FormHelper\Event\PreGenerateEvent;
use Netzmacht\FormHelper\Event\SelectLayoutEvent;
use Netzmacht\Contao\FormHelper\Partial\Container;
use Netzmacht\Contao\FormHelper\Partial\Label;
use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class Subscriber implements EventSubscriberInterface
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
	private static $noColumns = array(
		'explanation',
		'html',
		'headline'
	);


	/**
	 * @var array
	 */
	protected $noLabel = array('explanation', 'headline', 'html', 'submit');


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
			Events::GENERATE                  => array(
				array('generateCaptcha', 1000),
				array('generatePasswordConfirmation')
			),
		);
	}


	/**
	 * @param SelectLayoutEvent $event
	 */
	public function selectLayout(SelectLayoutEvent $event)
	{
		$widget = $event->getWidget();
		$form   = $event->getForm();

		if(version_compare(VERSION, '3.3', '>=')) {
			$event->setLayout('row');
		}
		// form can be null if form is not created from form generator
		elseif($form && $form->tableless) {
			$event->setLayout('tableless');
		}
		elseif(in_array($widget->type, static::$noColumns)) {
			$event->setLayout('table_nocolumns');
		}
		else {
			$event->setLayout('table');
		}
	}


	/**
	 * @param \Netzmacht\Contao\FormHelper\Event\BuildElementEvent $event
	 */
	public function buildElement(BuildElementEvent $event)
	{
		$widget  = $event->getWidget();
		$element = null;

		// widget generates an element
		if($widget instanceof GeneratesAnElement) {
			$element = $widget->generate();
			$event->setElement($element);

			return;
		}

		switch($widget->type) {
			case 'explanation':
			case 'headline':
				$element = Element::create('div');
				$element->addChild($widget->text);
				break;

			case 'html':
				$element = Element::create('div');
				$element->addChild($widget->html);
				break;

			case 'checkbox':
				$element = new Checkboxes();
				$element->setAttribute('name', $widget->name);
				break;

			case 'radio':
				$element = new Radios();
				$element->setAttribute('name', $widget->name);
				break;

			case 'captcha':
				// generate question to fetch the name of the captcha element, see #1
				/** @var \FormCaptcha $widget */
				$widget->generateQuestion();

				$name    = \Session::getInstance()->get('captcha_' . $widget->id);
				$element = Element::create('input', array('type' => 'text'));

				$element->setAttribute('name', $name['key']);
				break;

			case 'upload':
				$element = Element::create('input', array('type' => 'file'));
				$element->setAttribute('name', $widget->name);
				break;

			case 'password':
			case 'submit':
			case 'text':
			case 'digit':
			case 'email':
			case 'tel':
			case 'url':
				$element = Element::create('input', array('type' => $widget->type));
				$element->setAttribute('name', $widget->name);
				break;

			case 'textarea':
				$element = Element::create($widget->type);
				$element->setAttribute('name', $widget->name);
				break;

			case 'select':
				$element = new Select();
				$element->setAttribute('name', $widget->name);
				break;

			default:
				return;
		}

		$event->setElement($element);
	}


	/**
	 * @param \Netzmacht\Contao\FormHelper\Event\PreGenerateEvent $event
	 */
	public function setDefaults(PreGenerateEvent $event)
	{
		$widget    = $event->getWidget();
		$container = $event->getContainer();
		$element   = $container->getElement();
		$label     = $event->getLabel();
		$errors    = $event->getErrors();

		$this->presetErrors($errors);
		$this->presetLabel($label, $widget, $element);
		$this->presetElement($container, $element, $widget);
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
			$container->addChild('question', $question);
		}
	}


	/**
	 * @param GenerateEvent $event
	 */
	public function generatePasswordConfirmation(GenerateEvent $event)
	{
		$widget = $event->getWidget();

		if(!$widget instanceof \FormPassword) {
			return;
		}

		$container = $event->getContainer();
		$element   = $container->getElement();
		$label     = $event->getLabel();
		$id        = $element instanceof Element ? $element->getId() : ('ctrl_' . $widget->id);

		$repeatId    = $id . '_confirm';
		$repeatLabel = Element::create('label')
			->setAttribute('class', $label->getAttribute('class'))
			->addChild(sprintf($GLOBALS['TL_LANG']['MSC']['confirmation'], $widget->label))
			->setAttribute('for', $repeatId);

		if($widget->mandatory) {
			$mandatory = sprintf(
				'<span class="mandatory"><span class="invisible">%s</span>*</span>',
				$GLOBALS['TL_LANG']['MSC']['mandatory']
			);

			$repeatLabel->addChild($mandatory);
		}

		/** @var Element $repeat */
		$repeat = clone $element;
		$repeat->setId($repeatId)
			->setAttribute('name', $repeat->getAttribute('name') . '_confirm')
			->setAttribute('value', '');

		$container->addChild('repeat', $repeat);
		$container->addChild('repeatLabel', $repeatLabel);
	}


	/**
	 * @param Label $label
	 * @param \Widget $widget
	 * @param $element
	 */
	protected function presetLabel(Label $label, \Widget $widget, $element)
	{
		$label->setAttribute('for', 'ctrl_' . $widget->id);

		if($widget->label) {
			$label->addChild($widget->label);
		}

		if($widget->mandatory) {
			$mandatory = sprintf(
				'<span class="mandatory"><span class="invisible">%s</span>*</span>',
				$GLOBALS['TL_LANG']['MSC']['mandatory']
			);

			$label->addChild($mandatory);
		}

		if($element instanceof HasLabel) {
			$element->setLabel(new StaticHtml($widget->label));
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

			if($widget->imageSubmit) {
				$element
					->setAttribute('type', 'image')
					->setAttribute('src', \FilesModel::findByPk($widget->singleSRC)->path);
			}
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

		$transform = array('tabindex', 'accesskey', 'maxlength', 'placeholder', 'value');

		foreach($transform as $attribute) {
			if($widget->$attribute) {
				$element->setAttribute($attribute, $widget->$attribute);
			}
		}

		if($widget instanceof \FormFileUpload && $widget->size) {
			$element->setAttribute('size', $widget->size);
		}
	}


	/**
	 * @param Options $element
	 * @param \Widget $widget
	 */
	protected function presetOptions(Options $element, \Widget $widget)
	{
		$element->setValue($widget->value);
		$element->setOptions($widget->options);
	}


	/**
	 * @param Element $errors
	 */
	private function presetErrors(Element $errors)
	{
		$errors->addClass('error');;
	}


	/**
	 * @param \Netzmacht\Contao\FormHelper\Partial\Container $container
	 * @param $element
	 * @param $widget
	 */
	private function presetElement(Container $container, $element, $widget)
	{
		// unknown element type
		if(!$element instanceof Element) {
			return;
		}

		$element->setId('ctrl_' . $widget->id);
		$element->addClass($widget->type);

		$this->presetAttributes($element, $widget);

		if($element instanceof Options && $widget->options) {
			$this->presetOptions($element, $widget);
		}

		if($widget->type == 'submit') {
			$this->presetSubmit($element, $widget);
		}
		elseif($widget->addSubmit && $widget->type != 'submit') {
			$submit = Element::create('input');
			$submit->setAttribute('type', 'submit');
			$submit->setAttribute('value', $widget->slabel);

			$container->addChild('submit', $submit);
		}
	}
}
