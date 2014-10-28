<?php

namespace Netzmacht\Contao\FormHelper;

use Netzmacht\Html\CastsToString;

/**
 * Interface HasElement describes components which contains the Element.
 *
 * @package Netzmacht\Contao\FormHelper
 */
interface HasElement
{
    /**
     * Set the element.
     *
     * @param CastsToString|string $element The widget element.
     *
     * @return $this
     */
    public function setElement($element);

    /**
     * Get the element.
     *
     * @return CastsToString|string
     */
    public function getElement();
}
