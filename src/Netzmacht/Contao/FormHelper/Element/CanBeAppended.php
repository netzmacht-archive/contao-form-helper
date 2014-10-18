<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Element;

use Netzmacht\Html\Element\Node;

/**
 * Interface IsAppendAble
 * @package Netzmacht\FormHelper\Element
 */
interface CanBeAppended
{
	/**
	 * @param Node $parent
	 * @param string $position
	 * @return mixed
	 */
	public function appendTo(Node $parent, $position=Node::POSITION_LAST);

} 