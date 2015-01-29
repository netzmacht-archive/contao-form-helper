<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Form;

/**
 * Class FormLocator is loading the form models.
 *
 * @package Netzmacht\Contao\FormHelper\Form
 */
class FormLocator
{
    /**
     * Load form model from database.
     *
     * @param int $formId The form id.
     *
     * @return \FormModel|null
     */
    public function getForm($formId)
    {
        return \FormModel::findByPk($formId);
    }
}
