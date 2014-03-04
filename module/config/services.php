<?php

/** @var \Pimple $container */
$container = $GLOBALS['container'];

$GLOBALS['container']['form-helper'] = $container->share(function(\Pimple $c) {
	return new \Netzmacht\FormHelper\Helper($c['event-dispatcher'], $c['form-helper.form-locator']);
});

$GLOBALS['container']['form-helper.form-locator'] = $container->share(function(\Pimple $c) {
	return new \Netzmacht\FormHelper\FormLocator(
		new \Netzmacht\FormHelper\Registry(),
		\Database::getInstance()
	);
});

$GLOBALS['container']['form-helper.validation'] = $container->share(function(\Pimple $c) {
	return new \Netzmacht\FormHelper\Validation($c['event-dispatcher'], $c['form-helper.form-locator']);
});