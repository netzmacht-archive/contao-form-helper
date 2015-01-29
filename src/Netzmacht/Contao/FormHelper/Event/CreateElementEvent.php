<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Html\Element;

/**
 * Class CreateElementEvent is raised when creating the element.
 *
 * @package Netzmacht\Contao\FormHelper\Event
 */
class CreateElementEvent extends ViewEvent
{
    /**
     * The created element.
     *
     * @var Element
     */
    private $element;

    /**
     * Get the corresponding widget.
     *
     * @return \Widget
     */
    public function getWidget()
    {
        return $this->getView()->getWidget();
    }

    /**
     * Set a created element.
     *
     * @param Element $element The created element.
     *
     * @return $this
     */
    public function setElement(Element $element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get the created element.
     *
     * @return Element mixed
     */
    public function getElement()
    {
        return $this->element;
    }
}
