<?php

namespace Netzmacht\FormHelper\Event;

/**
 * Class Events
 * @package Netzmacht\FormHelper\Event
 */
class Events
{
	const BUILD_ELEMENT         = 'form-helper.build-element';

	const PRE_GENERATE          = 'form-helper.pre-generate-widget';

	const GENERATE              = 'form-helper.generate-widget';

	const SELECT_LAYOUT         = 'form-helper.select-widget-layout';

	const SELECT_MESSAGE_LAYOUT = 'form-helper.select-message-layout';

	const CREATE_ELEMENT        = 'form-helper.crete-element';

}