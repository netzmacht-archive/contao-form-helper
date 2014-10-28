<?php


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
