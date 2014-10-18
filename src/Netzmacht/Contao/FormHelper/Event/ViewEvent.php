<?php

namespace Netzmacht\Contao\FormHelper\Event;

use Netzmacht\Contao\FormHelper\View;
use Symfony\Component\EventDispatcher\Event;

class ViewEvent extends Event
{
    /**
     * @var View
     */
    private $view;


    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view   = $view;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }
}
