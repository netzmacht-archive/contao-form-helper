<?php

namespace Netzmacht\Contao\FormHelper\Event;

/**
 * Class Events
 * @package Netzmacht\FormHelper\Event
 */
class Events
{
    const BUILD_ELEMENT = 'netzmacht.form-helper.build-element';

    const PRE_GENERATE  = 'netzmacht.form-helper.pre-generate-widget';

    const GENERATE      = 'netzmacht.form-helper.generate-widget';

    const CREATE_VIEW   = 'netzmacht.form-helper.create-view';
}
