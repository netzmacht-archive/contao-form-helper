<?php

namespace spec\Netzmacht\Contao\FormHelper;

use Netzmacht\Contao\FormHelper\Event\CreateElementEvent;
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

    const CREATE_ELEMENT_EVENT_CLASS = 'Netzmacht\Contao\FormHelper\Event\CreateElementEvent';

    function let(EventDispatcher $eventDispatcher, FormLocator $formLocator)
    {
        $this->beConstructedWith($eventDispatcher, $formLocator);

        if (!isset($GLOBALS['TL_FFL'])) {
            $GLOBALS['TL_FFL'] = array();
        }
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
            ->dispatch(Events::CREATE_ELEMENT, Argument::type(self::CREATE_ELEMENT_EVENT_CLASS))
            ->will(function($args) {
                    /** @var CreateElementEvent $event */
                    $event = $args[1];
                    $event->setElement(new Node('input'));
                });

        $eventDispatcher
            ->dispatch(Events::PRE_GENERATE_VIEW, Argument::type(self::VIEW_EVENT_CLASS))
            ->shouldBeCalled();

        $eventDispatcher
            ->dispatch(Events::GENERATE_VIEW, Argument::type(self::VIEW_EVENT_CLASS))
            ->shouldBeCalled();

        $this->createView($widget)->shouldBeAnInstanceOf(self::VIEW_CLASS);
    }
}
