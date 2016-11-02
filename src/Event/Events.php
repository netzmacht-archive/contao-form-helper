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
     * CREATE_VIEW event is raised first during generating the view. The event gets an default view instance and
     * is configured during this event. The element is not available yet.
     *
     * The raised event is an instance of ViewEvent.
     */
    const CREATE_VIEW = 'form-helper.create-view';

    /**
     * CREATE_ELEMENT is raised after the view is created. It creates an form element instance which is used
     * in the rendering process
     *
     * The raised event is an instance of CreateElementEvent.
     */
    const CREATE_ELEMENT = 'form-helper.create-element';

    /**
     * PRE_GENERATE_VIEW is raised after the element is created. It's purpose is to setup the element with
     * specific configuration
     *
     * The raised event is an instance of ViewEvent.
     */
    const PRE_GENERATE_VIEW = 'form-helper.pre-generate-view';

    /**
     * GENERATE_VIEW is raised after PRE_GENERATE_VIEW. It's pupose is to make generating decisions on a
     * fully configured view and element.
     *
     * The raised event is an instance of ViewEvent.
     */
    const GENERATE_VIEW = 'form-helper.generate-view';
}
