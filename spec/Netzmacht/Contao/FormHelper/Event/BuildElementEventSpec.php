<?php

namespace spec\Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Contao\FormHelper\Event\BuildElementEvent;
use Netzmacht\Contao\FormHelper\View;
use Netzmacht\Html\Element;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BuildElementEventSpec
 * @package spec\Netzmacht\Contao\FormHelper\Event
 * @mixin BuildElementEvent
 */
class BuildElementEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\FormHelper\Event\BuildElementEvent');
    }

    function let(View $view, \Widget $widget)
    {
        $view->getWidget()->willReturn($widget);

        $this->beConstructedWith($view);
    }

    function it_gets_the_view(View $view)
    {
        $this->getView()->shouldReturn($view);
    }

    function it_gets_widget(\Widget $widget)
    {
        $this->getWidget()->shouldReturn($widget);
    }

    function it_sets_and_gets_an_element(Element $element)
    {
        $this->setElement($element)->shouldReturn($this);
        $this->getElement()->shouldReturn($element);
    }
}
