<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Element;

use Netzmacht\Html\Element\Node;

/**
 * Interface IsAppendAble describes elements which can be appended to other elements.
 *
 * @package Netzmacht\FormHelper\Element
 */
interface CanBeAppended
{
    /**
     * Append element to a node.
     *
     * @param Node   $parent   The parent node.
     * @param string $position The position where to insert.
     *
     * @return mixed
     */
    public function appendTo(Node $parent, $position = Node::POSITION_LAST);
}
