<?php

/** @var \Pimple $container */
$container = $GLOBALS['container'];

$GLOBALS['container']['form-helper'] = $container->share(function(\Pimple $c) {
	return new \Netzmacht\FormHelper\Helper($c['event-dispatcher'], \Database::getInstance());
});