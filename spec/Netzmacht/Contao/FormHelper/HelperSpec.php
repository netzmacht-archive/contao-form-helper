<?php

namespace spec\Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\CreateViewEvent;
use Netzmacht\Contao\FormHelper\Form\FormLocator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as EventDispatcher;

/**
 * Class HelperSpec
 * @package spec\Netzmacht\Contao\FormHelper
 * @mixin \Netzmacht\Contao\FormHelper\Helper
 */
class HelperSpec extends ObjectBehavior
{
    const VIEW_CLASS = 'Netzmacht\Contao\FormHelper\View';

    const HELPER_CLASS = 'Netzmacht\Contao\FormHelper\Helper';

    const CREATE_VIEW_EVENT_CLASS = 'Netzmacht\Contao\FormHelper\Event\CreateViewEvent';

    function let(EventDispatcher $eventDispatcher, FormLocator $formLocator)
    {
        $this->beConstructedWith($eventDispatcher, $formLocator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(self::HELPER_CLASS);
    }

    function it_creates_a_view(\Widget $widget, EventDispatcher $eventDispatcher)
    {
        $widget->getErrors()->willReturn(array());

        $eventDispatcher
            ->dispatch(CreateViewEvent::NAME, Argument::type(self::CREATE_VIEW_EVENT_CLASS))
            ->shouldBeCalled();

        $this->createView($widget)->shouldBeAnInstanceOf(self::VIEW_CLASS);
    }
}
