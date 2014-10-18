<?php

namespace spec\Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\BuildElementEvent;
use Netzmacht\Contao\FormHelper\Event\Events;
use Netzmacht\Contao\FormHelper\Form\FormLocator;
use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
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

    const VIEW_EVENT_CLASS = 'Netzmacht\Contao\FormHelper\Event\ViewEvent';

    const BUILD_ELEMENT_EVENT_CLASS = 'Netzmacht\Contao\FormHelper\Event\BuildElementEvent';

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
            ->dispatch(Events::CREATE_VIEW, Argument::type(self::VIEW_EVENT_CLASS))
            ->shouldBeCalled();

        $eventDispatcher
            ->dispatch(Events::BUILD_ELEMENT, Argument::type(self::BUILD_ELEMENT_EVENT_CLASS))
            ->will(function($args) {
                    /** @var BuildElementEvent $event */
                    $event = $args[1];
                    $event->setElement(new Node('input'));
                });

        $eventDispatcher
            ->dispatch(Events::PRE_GENERATE, Argument::type(self::VIEW_EVENT_CLASS))
            ->shouldBeCalled();

        $eventDispatcher
            ->dispatch(Events::GENERATE, Argument::type(self::VIEW_EVENT_CLASS))
            ->shouldBeCalled();

        $this->createView($widget)->shouldBeAnInstanceOf(self::VIEW_CLASS);
    }
}
