<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

\TemplateLoader::addFile('formhelper_element_container', 'system/modules/form-helper/templates/element');
\TemplateLoader::addFile('formhelper_element_checkboxes', 'system/modules/form-helper/templates/element');
\TemplateLoader::addFile('formhelper_element_radios', 'system/modules/form-helper/templates/element');
\TemplateLoader::addFile('formhelper_element_select', 'system/modules/form-helper/templates/element');

\TemplateLoader::addFile('formhelper_error_all', 'system/modules/form-helper/templates/error');
\TemplateLoader::addFile('formhelper_error_last', 'system/modules/form-helper/templates/error');

\TemplateLoader::addFile('form_explanation', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_widget', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_captcha', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_checkbox', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_headline', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_password', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_radio', 'system/modules/form-helper/templates/widget');
\TemplateLoader::addFile('form_submit', 'system/modules/form-helper/templates/widget');

\TemplateLoader::addFile('formhelper_layout_tableless', 'system/modules/form-helper/templates/layout');
\TemplateLoader::addFile('formhelper_layout_table', 'system/modules/form-helper/templates/layout');
\TemplateLoader::addFile('formhelper_layout_table_nocolumns', 'system/modules/form-helper/templates/layout');

if(version_compare(VERSION, '3.3', '>=')) {
    \TemplateLoader::addFile('form_textfield', 'system/modules/form-helper/templates/widget');
    \TemplateLoader::addFile('form_textarea', 'system/modules/form-helper/templates/widget');
    \TemplateLoader::addFile('form_select', 'system/modules/form-helper/templates/widget');
    \TemplateLoader::addFile('form_upload', 'system/modules/form-helper/templates/widget');
}
