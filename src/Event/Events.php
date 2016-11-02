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

/**
 * Class Events stores the event names of the form helper. You can find the descriptions below.
 *
 * @package Netzmacht\FormHelper\Event
 */
class Events
{
    /**
     * CREATE_VIEW event is raised first during generating the view. It's purpose is to manipulate the widget.
     *
     * The raised event is an instance of ViewEvent.
     */
    const CREATE_VIEW = 'form-helper.create-view';

    /**
     * GENERATE_VIEW is raised after CREATE_VIEW. It's purpose is to generate additional blocks
     *
     * The raised event is an instance of ViewEvent.
     */
    const GENERATE_VIEW = 'form-helper.generate-view';
}
