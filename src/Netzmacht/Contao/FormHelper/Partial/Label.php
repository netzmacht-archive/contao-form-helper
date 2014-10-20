<?php

namespace Netzmacht\Contao\FormHelper\Partial;

use Netzmacht\Html\Element\Node;

class Label extends Node
{
    /**
     * @var bool
     */
    protected $visible = true;

    /**
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct('label', $attributes);
    }

    /**
     * Hide label
     *
     * @return $this
     */
    public function hide()
    {
        $this->visible = false;

        return $this;
    }

    /**
     * Show label
     * @return $this;
     */
    public function show()
    {
        $this->visible = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @return string
     */
    public function generate()
    {
        if ($this->isVisible()) {
            return parent::generate();
        }

        return '';
    }
}
