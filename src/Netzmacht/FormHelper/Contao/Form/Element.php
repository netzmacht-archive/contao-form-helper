<?php

namespace Netzmacht\FormHelper\Contao\Form;


use Netzmacht\FormHelper\Component\Errors;
use Netzmacht\FormHelper\Helper;

class Element extends \Widget
{

	/**
	 * @var
	 */
	protected $generated;

	/**
	 * @var string
	 */
	protected $strTemplate = 'form_widget';


	/**
	 * @param null $arrAttributes
	 * @return string
	 */
	public function parse($arrAttributes = null)
	{
		if($arrAttributes) {
			$this->addAttributes($arrAttributes);
			$arrAttributes = null;
		}

		$this->preGenerate();

		return parent::parse($arrAttributes);
	}


	/**
	 * Generate the widget and return it as string
	 *
	 * @return string The widget markup
	 */
	public function generate()
	{
		$this->preGenerate();
		return $this->generated[1];
	}


	/**
	 * @return string
	 */
	public function generateLabel()
	{
		$this->preGenerate();
		return $this->generated[0];
	}


	/**
	 * @param int $intIndex
	 * @return Errors|string
	 */
	public function getErrorAsHTML($intIndex = 0)
	{
		if($intIndex == 0) {
			$this->preGenerate();
			return $this->generated[2];
		}

		return parent::getErrorAsHTML($intIndex);
	}


	/**
	 *
	 */
	protected function preGenerate()
	{
		if(!$this->generated) {
			$helper = Helper::getInstance();
			$this->generated = $helper->generate($this);
		}
	}


} 