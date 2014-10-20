<?php

namespace Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Html\Element;

class BuildElementEvent extends ViewEvent
{

    /**
     * @var Element $element
     */
    private $element;

    /**
     * @return \Widget
     */
    public function getWidget()
    {
        return $this->getView()->getWidget();
    }

    /**
     * @param  Element $element
     * @return $this
     */
    public function setElement(Element $element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * @return Element mixed
     */
    public function getElement()
    {
        return $this->element;
    }
}
