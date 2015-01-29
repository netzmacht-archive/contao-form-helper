<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

/** @var \Pimple $container */
$container = $GLOBALS['container'];

$GLOBALS['container']['form-helper'] = $container->share(function(\Pimple $c) {
    return new \Netzmacht\Contao\FormHelper\Helper($c['event-dispatcher'], $c['form-helper.form-locator']);
});

$GLOBALS['container']['form-helper.form-locator'] = $container->share(function(\Pimple $c) {
    return new \Netzmacht\Contao\FormHelper\Form\FormLocator();
});
