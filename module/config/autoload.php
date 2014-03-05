<?php

\NamespaceClassLoader::add('Netzmacht', 'system/modules/formHelper');

\TemplateLoader::addFile('formhelper_element_container', 'system/modules/formHelper/templates/element');
\TemplateLoader::addFile('formhelper_element_default', 'system/modules/formHelper/templates/element');
\TemplateLoader::addFile('formhelper_element_checkboxes', 'system/modules/formHelper/templates/element');
\TemplateLoader::addFile('formhelper_element_radios', 'system/modules/formHelper/templates/element');
\TemplateLoader::addFile('formhelper_element_select', 'system/modules/formHelper/templates/element');

\TemplateLoader::addFile('formhelper_error_all', 'system/modules/formHelper/templates/error');
\TemplateLoader::addFile('formhelper_error_last', 'system/modules/formHelper/templates/error');

\TemplateLoader::addFile('form_explanation', 'system/modules/formHelper/templates/widget');
\TemplateLoader::addFile('form_widget', 'system/modules/formHelper/templates/widget');
\TemplateLoader::addFile('form_captcha', 'system/modules/formHelper/templates/widget');
\TemplateLoader::addFile('form_checkbox', 'system/modules/formHelper/templates/widget');
\TemplateLoader::addFile('form_headline', 'system/modules/formHelper/templates/widget');
\TemplateLoader::addFile('form_radio', 'system/modules/formHelper/templates/widget');
\TemplateLoader::addFile('form_submit', 'system/modules/formHelper/templates/widget');

\TemplateLoader::addFile('formhelper_layout_tableless', 'system/modules/formHelper/templates/layout');
\TemplateLoader::addFile('formhelper_layout_table', 'system/modules/formHelper/templates/layout');
\TemplateLoader::addFile('formhelper_layout_table_nocolumns', 'system/modules/formHelper/templates/layout');
