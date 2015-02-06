Contao Form Helper - Extended form rendering
==================

[![Build Status](http://img.shields.io/travis/netzmacht/contao-form-helper/develop.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-form-helper)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-form-helper.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-form-helper)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-form-helper.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-form-helper)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-form-helper.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-form-helper)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)

This library provides extended form widget rendering for Contao frontend form widgets. By default the rendering of
Contao forms widgets are not very customizable because of inline html rendering. Adjust output can be quite difficult.

Contao Form Helper provides an *event driven form rendering* which is fully backward compatible. This means that it
supports the html output usually provided by Contao. Also every widgets from extension will work without any customizing.

Contao Form Helper renders the form in two steps. First it creates objects representing the HTML elements before passing
them to the templates. Using the event driven interface it is possible to simply change attributes, provide extra features
and so on.

Installation
-----

To install the extension simply install `netzmacht/contao-form-helper` using the
[Composer](http://c-c-a.org/ueber-composer) repository.

Changelog
---------

Changes between 0.x version and 1.x
 * Change namespace of `Netzmacht\FormHelper` to `Netzmacht\Contao\FormHelper`
 * Using a view object which is created instead of return an array of elements
 * Simplify events (no select message event anymore)
 * Introduce an attributes object for
 * Drop supporting form messages handling

How it works
-----

By default this extension enables the extended form rendering for every form widget which is shipped with Contao. They
are activated by customized form templates.

The helper creates a view object for each widget. The view contains:
 * Attributes which can be used for a wrapper `<div>`
 * The form label
 * Container including the element and by default the extra submit button
 * Error messages
 * Using a layout which is used to render

```php
<?php

// form_widget.html5

// shortcut
Netzmacht\Contao\FormHelper\Helper::generate($this);

// what actually happens
$helper = Netzmacht\Contao\FormHelper\Helper::getInstance();

/** @var Netzmacht\Contao\FromHelper\View */
$view   = $helper->createView($view);

echo $view->render();

```

Events
----------

Events are dispatched by the (Contao Event dispatcher)[https://github.com/contao-community-alliance/event-dispatcher].
Each event names are stored in `Netzmacht\Contao\FormHelper\Event\Events`:
 * `Events::CREATE_VIEW` is triggered first to create the view instance. The element is not available at this moment
 * `Events::CREATE_ELEMENT` is fired when creating the html element of the given widget
 * `Events::PRE_GENERATE_VIEW` is fired after creating the element
 * `Events::GENERATE_VIEW` is fired for generating the

Customizing widgets
----------

There are two ways for manipulating the output. The proposed way is writing your custom events

```php
<?php
// config.php

$GLOBALS['TL_EVENTS'][Netzmacht\Contao\FormHelper\Event\Events::GENERATE_VIEW][] = function(Netzmacht\Contao\FormHelper\Event\ViewEvent $event) {
	// access Contao widget and form
	$form 	= $event->getFormModel();
	$widget = $event->getWidget();

	// adjust element
	$container = $event->getContainer();
	$element   = $container->getElement();

	// adjust rows
	if($form->id == 9 && $widget->type == 'textarea') {
		$element->setAttribute('rows', 50);
	}
}
```

You can also adjust the rendering using the templates:

```php
<?php
// form_widget.html5
$helper = Netzmacht\Contao\FormHelper\Helper::getInstance();

/** @var Netzmacht\Contao\FromHelper\View */
$view   = $helper->createView($view);
$errors = $view->getErrors();

// display all errors which belongs to an element
$errors->setTemplateName('formhelper_error_all');

// wrapping element can be a string with %s placeholder or an Netzmacht\Html\Node object
$wrapper = '<div class="form-element">%s</div>';

$container = $view->getContainer();
$container->add('wrapper', $wrapper, $container::POSITION_WRAPPER);

echo $view->render();
