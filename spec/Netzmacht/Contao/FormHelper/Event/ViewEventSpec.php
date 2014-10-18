<?php

namespace spec\Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Contao\FormHelper\Event\ViewEvent;
use Netzmacht\Contao\FormHelper\View;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CreateViewEventSpec
 * @package spec\Netzmacht\Contao\FormHelper\Event
 * @mixin ViewEvent
 */
class ViewEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Contao\FormHelper\Event\CreateViewEvent');
        $this->shouldBeAnInstanceOf('Symfony\Component\EventDispatcher\Event');
    }

    function let(\Widget $widget, View $view)
    {
        $this->beConstructedWith($widget, $view);
    }

    function it_gets_the_widget(\Widget $widget)
    {
        $this->getWidget()->shouldReturn($widget);
    }

    function it_gets_the_view(View $view)
    {
        $this->getView()->shouldReturn($view);
    }

}
