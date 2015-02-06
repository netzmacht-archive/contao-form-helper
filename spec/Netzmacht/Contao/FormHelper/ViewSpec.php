<?php

namespace spec\Netzmacht\Contao\FormHelper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

if(!defined('TL_MODE')) {
    define('TL_MODE', 'FE');
}


/**
 * Class ViewSpec
 * @package spec\Netzmacht\Contao\FormHelper
 * @mixin \Netzmacht\Contao\FormHelper\View
 */
class ViewSpec extends ObjectBehavior
{
    const LAYOUT_NAME = 'layout';

    const ATTRIBUTES_CLASS = 'Netzmacht\Html\Attributes';

    const CONTAINER_CLASS = 'Netzmacht\Contao\FormHelper\Partial\Container';

    const ERRORS_CLASS = 'Netzmacht\Contao\FormHelper\Partial\Errors';

    const LABEL_CLASS = 'Netzmacht\Contao\FormHelper\Partial\Label';

    const MESSAGE_LAYOUT = 'message_layout';

    function let(\Widget $widget)
    {
        $widget->getErrors()->willReturn(array());
        $this->beConstructedWith($widget);

        if(!class_exists('FrontendTemplate', false)) {
            class_alias('spec\Netzmacht\Contao\FormHelper\FrontendTemplate', 'FrontendTemplate');
        }

        if (!isset($GLOBALS['TL_FFL'])) {
            $GLOBALS['TL_FFL'] = array();
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\FormHelper\View');
    }

    /**
     * @param \Widget $widget
     * @param \FormModel $form
     */
    function it_can_be_constructed_with_form(\Widget $widget, \FormModel $form)
    {
        $this->beConstructedWith($widget, $form);
        $this->getFormModel()->shouldReturn($form);
        $this->hasFormModel()->shouldReturn(true);
    }

    function it_gets_the_widget(\Widget $widget)
    {
        $this->getWidget()->shouldReturn($widget);
    }

    function it_sets_and_gets_a_layout()
    {
        $this->setLayout(static::LAYOUT_NAME)->shouldReturn($this);
        $this->getLayout()->shouldReturn(static::LAYOUT_NAME);
    }

    function it_has_attributes()
    {
        $this->getAttributes()->shouldBeAnInstanceOf(self::ATTRIBUTES_CLASS);
    }

    function it_knows_about_form()
    {
        $this->hasFormModel()->shouldReturn(false);
    }

    function it_has_a_container()
    {
        $this->getContainer()->shouldHaveType(self::CONTAINER_CLASS);
    }

    function it_has_errors()
    {
        $this->getErrors()->shouldHaveType(self::ERRORS_CLASS);
    }

    function it_has_a_label()
    {
        $this->getLabel()->shouldHaveType(self::LABEL_CLASS);
    }

    function it_has_a_visibility_state()
    {
        $this->isVisible()->shouldReturn(true);
        $this->setVisible(false)->shouldReturn($this);
        $this->isVisible()->shouldReturn(false);
    }

    function it_renders()
    {
        $this->setLayout('table');

        $this->render()->shouldBeString();
    }

}

class FrontendTemplate
{
    function parse()
    {
        return '';
    }
}
