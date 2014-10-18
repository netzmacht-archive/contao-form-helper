<?php

namespace Netzmacht\Contao\FormHelper\Event;

/**
 * Class Events
 * @package Netzmacht\FormHelper\Event
 */
class Events
{
    const BUILD_ELEMENT = 'form-helper.build-element';

    const PRE_GENERATE  = 'form-helper.pre-generate-widget';

    const GENERATE      = 'form-helper.generate-widget';

    const CREATE_VIEW   = 'form-helper.create-view';
}
