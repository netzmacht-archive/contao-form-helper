<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Partial;

use Netzmacht\Contao\FormHelper\HasElement;
use Netzmacht\Html\CastsToString;
use Netzmacht\Html\Element;

/**
 * Class Container is the main component of the widget view. It contains the element and can also store elements before
 * and after the element.
 *
 * @package Netzmacht\Contao\FormHelper\Partial
 */
class Container extends TemplateComponent
{
    const POSITION_BEFORE = 'before';
    const POSITION_AFTER  = 'after';

    /**
     * The widget element.
     *
     * @var Element
     */
    protected $element;

    /**
     * Containing children.
     *
     * @var array
     */
    protected $children = array();

    /**
     * Positions of children elements.
     *
     * @var array
     */
    protected $position = array();

    /**
     * A wrapper element.
     *
     * @var HasElement
     */
    protected $wrapper;

    /**
     * Name of a template which can be used to render the element inside of it.
     *
     * @var string
     */
    protected $elementTemplate;

    /**
     * Render the container as wrapping html element.
     *
     * @var bool
     */
    protected $renderContainer = false;

    /**
     * Construct.
     *
     * @param array $attributes Default html attributes.
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->renderContainer = false;
    }

    /**
     * Enable the rendering of the container as a wrapping html element.
     *
     * @param boolean $renderContainer Enable or disable.
     *
     * @return $this
     */
    public function setRenderContainer($renderContainer)
    {
        $this->renderContainer = (bool) $renderContainer;

        return $this;
    }

    /**
     * Check if container will be rendered as wrapping element.
     *
     * @return boolean
     */
    public function isRendered()
    {
        return $this->renderContainer;
    }

    /**
     * Set a wrapper component. The wrapper will only wrap the element.
     *
     * @param HasElement $wrapper The wrapper element.
     *
     * @return $this
     */
    public function setWrapper(HasElement $wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * Get the wrapper.
     *
     * @return mixed
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * Get all children.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the widget element.
     *
     * @param CastsToString|string $element The widget element.
     *
     * @return $this
     */
    public function setElement($element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get the widget element.
     *
     * @return CastsToString|string
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Set the elemenent template name. It's used to wrap the element.
     *
     * @param string $elementTemplate A template name.
     *
     * @return $this
     */
    public function setElementTemplateName($elementTemplate)
    {
        $this->elementTemplate = $elementTemplate;

        return $this;
    }

    /**
     * Get the template name.
     *
     * @return string|null
     */
    public function getElementTemplateName()
    {
        return $this->elementTemplate;
    }

    /**
     * Add a child to the container.
     *
     * @param string $name     A unique name of the child.
     * @param mixed  $child    The child component. Can be a string or any CastsToString elements.
     * @param string $position Define the position of the children.
     *
     * @return $this
     */
    public function addChild($name, $child, $position = self::POSITION_AFTER)
    {
        $this->children[$name] = $child;
        $this->position[$name] = $position;

        return $this;
    }

    /**
     * The a child by it's name. Throws an exception if child is not found.
     *
     * @param string $name The child name.
     *
     * @return CastsToString|string
     *
     * @throws \Exception If child is not found.
     */
    public function getChild($name)
    {
        if ($this->hasChild($name)) {
            return $this->children[$name];
        }

        throw new \Exception(sprintf('Unknown child with name "%s"', $name));
    }

    /**
     * Get the position of the child. Throws if child is not set.
     *
     * @param string $name The child name.
     *
     * @return string
     *
     * @throws \Exception If child does not exists.
     */
    public function getChildPosition($name)
    {
        if ($this->hasChild($name)) {
            return $this->position[$name];
        }

        throw new \Exception(sprintf('Unkown child with name "%s"', $name));
    }

    /**
     * Get children by the position.
     *
     * @param string $destination The wanted posititon.
     *
     * @return array
     */
    public function getChildByPosition($destination)
    {
        $before = array();

        foreach ($this->position as $name => $position) {
            if ($position == $destination) {
                $before[$name] = $this->children[$name];
            }
        }

        return $before;
    }

    /**
     * Remove a child by name. Returns the child if it exists.
     *
     * @param string $name The child name.
     *
     * @return CastsToString|string
     */
    public function removeChild($name)
    {
        if ($this->hasChild($name)) {
            $child = $this->getChild($name);

            unset($this->children[$name]);
            unset($this->position[$name]);

            return $child;
        }

        return null;
    }

    /**
     * Rearrange order of assigned elements.
     *
     * @param array $order Can be a list of element names or an reset of position as well.
     *
     * @return $this
     */
    public function rearrangeChildren(array $order)
    {
        $position       = $this->position;
        $this->position = array();

        // rearrange order
        foreach ($order as $item => $pos) {
            if (!is_string($item)) {
                $item = $pos;
                $pos  = $position[$item];
            }

            if (isset($position[$item])) {
                $this->position[$item] = $pos;
                unset($position[$item]);
            }
        }

        // apply old orders of not mentioned elements
        foreach ($position as $item => $pos) {
            $this->position[$item] = $pos;
        }

        return $this;
    }

    /**
     * Consider if child exists.
     *
     * @param string $name The child name.
     *
     * @return bool
     */
    public function hasChild($name)
    {
        return isset($this->children[$name]);
    }

    /**
     * Generate the container.
     *
     * @return string
     */
    public function generate()
    {
        if ($this->template) {
            $template = new \FrontendTemplate($this->template);

            $template->before    = $this->getChildByPosition(static::POSITION_BEFORE);
            $template->after     = $this->getChildByPosition(static::POSITION_AFTER);
            $template->container = $this;

            if ($this->wrapper) {
                $template->element = $this->wrapper;
            } else {
                $template->element = $this->element;
            }

            return $template->parse();
        }

        $buffer  = $this->generateChildren(static::POSITION_BEFORE);
        $buffer .= $this->generateElement();
        $buffer .= $this->generateChildren(static::POSITION_AFTER);

        if ($this->renderContainer) {
            return sprintf('<div %s>%s%s%s</div>%s', $this->generateAttributes(), PHP_EOL, $buffer, PHP_EOL, PHP_EOL);
        }

        return $buffer;
    }

    /**
     * Casts to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->generate();
    }

    /**
     * Generate all children of a given position.
     *
     * @param string $position The wanted position.
     *
     * @return string
     */
    public function generateChildren($position)
    {
        $buffer = '';

        foreach ($this->getChildByPosition($position) as $child) {
            $buffer .= (string) $child;
        }

        return $buffer;
    }

    /**
     * Generate the element.
     *
     * @return string
     */
    public function generateElement()
    {
        if ($this->elementTemplate) {
            $template = new \FrontendTemplate($this->elementTemplate);

            $template->element = $this->element;

            $element = $template->parse();
        } else {
            $element = (string) $this->element;
        }

        if ($this->wrapper) {
            $this->wrapper->setElement($element);
            $element = (string) $this->wrapper;
        }

        return $element;
    }
}
