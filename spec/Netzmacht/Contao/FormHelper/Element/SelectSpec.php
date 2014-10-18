<?php

namespace spec\Netzmacht\Contao\FormHelper\Element;

use Netzmacht\Contao\FormHelper\Element\Select;
use Netzmacht\Contao\FormHelper\Partial\Label;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class SelectSpec
 * @package spec\Netzmacht\Contao\FormHelper\Element
 * @mixin Select
 */
class SelectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\FormHelper\Element\Select');
    }

    function it_has_options()
    {
        $this->setOptions($this->buildOptions())->shouldReturn($this);
        $this->getOptions()->shouldReturn($this->buildOptions());
    }

    function it_sets_a_string_value_as_array()
    {
        $this->setValue('test')->shouldReturn($this);
        $this->getValue()->shouldReturn(array('test'));
    }

    function it_sets_an_empty_string_as_empty_array()
    {
        $this->setValue('')->shouldReturn($this);
        $this->getValue()->shouldReturn(array());
    }

    function it_sets_an_array_as_value()
    {
        $this->setValue(array('test'))->shouldReturn($this);
        $this->getValue()->shouldReturn(array('test'));
    }

    function it_can_return_default_value_if_no_value_set()
    {
        $options = $this->buildOptions();
        $options[0]['default'] = 1;

        $this->setOptions($options);
        $this->getValue()->shouldReturn(array());
        $this->getValue(true)->shouldReturn(array('test'));
    }

    function it_ignores_request_for_default_value_if_value_set()
    {
        $options = $this->buildOptions();
        $options[0]['default'] = 1;

        $this->setOptions($options);
        $this->setValue('test2');
        $this->getValue(true)->shouldReturn(array('test2'));
    }

    function it_uses_a_template()
    {
        $this->setTemplateName('template')->shouldReturn($this);
        $this->getTemplateName()->shouldReturn('template');
    }

    /**
     * @return array
     */
    public function buildOptions()
    {
        return array(array('value' => 'test', 'label' => 'Test'));
    }
}
