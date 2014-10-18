<?php

$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\CreateViewSubscriber';
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\BuildElementSubscriber';
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\PreGenerateSubscriber';
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Netzmacht\Contao\FormHelper\Subscriber\GenerateSubscriber';
