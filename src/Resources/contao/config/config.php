<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\CreateViewSubscriber';
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\CreateElementSubscriber';
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\PreGenerateSubscriber';
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\GenerateSubscriber';
