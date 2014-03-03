<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 03.03.14
 * Time: 15:27
 */

namespace Netzmacht\FormHelper\Event;


use Symfony\Component\EventDispatcher\Event;

class SelectMessageLayoutEvent extends Event
{

	/**
	 * @var \FrontendTemplate
	 */
	protected $template;

	/**
	 * @var string
	 */
	protected $layout;


	/**
	 * @param \FrontendTemplate $template
	 */
	function __construct(\FrontendTemplate $template)
	{
		$this->template = $template;
	}


	/**
	 * @param string $layout
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}


	/**
	 * @return string
	 */
	public function getLayout()
	{
		return $this->layout;
	}


	/**
	 * @return \FrontendTemplate
	 */
	public function getTemplate()
	{
		return $this->template;
	}

} 