<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 01.03.14
 * Time: 10:20
 */

namespace Netzmacht\FormHelper;

/**
 * Class GenerateableInterface
 * @package Netzmacht\FormHelper
 */
interface GenerateInterface
{

	/**
	 * @return mixed
	 */
	public function generate();


	/**
	 * @return mixed
	 */
	public function __toString();

} 