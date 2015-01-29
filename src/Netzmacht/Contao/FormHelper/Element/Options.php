<?php

/**
 * @package    contao-form-helper
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormHelper\Element;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element\Node;
use Netzmacht\Contao\FormHelper\HasTemplate;

/**
 * Class Options provides an option argument storing possible option values.
 *
 * @package Netzmacht\Contao\FormHelper\Element
 */
abstract class Options extends Node implements HasTemplate
{

    /**
     * Html tag of the wrapping element.
     *
     * @var string
     */
    const CONTAINER_TAG = 'div';

    /**
     * The current value.
     *
     * @var array
     */
    protected $value = array();

    /**
     * Possible value options.
     *
     * @var array
     */
    protected $options = array();

    /**
     * The Contao template name.
     *
     * @var string
     */
    protected $template;

    /**
     * Child attributes.
     *
     * @var Attributes
     */
    protected $childAttributes;

    /**
     * Construct.
     *
     * @param string $tag        Element tag.
     * @param array  $attributes Attributes.
     */
    public function __construct($tag, $attributes = array())
    {
        parent::__construct($tag, $attributes);

        $this->childAttributes = new Attributes();
    }

    /**
     * Get child attributes.
     *
     * @return Attributes
     */
    public function getChildAttributes()
    {
        return $this->childAttributes;
    }

    /**
     * Set value options.
     *
     * @param mixed $options Options which have to be transformable to an array.
     *
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options  = (array) $options;
        $this->children = array();

        return $this;
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the current value.
     *
     * @param mixed $value Current value.
     *
     * @return $this
     */
    public function setValue($value)
    {
        if (!$value) {
            $value = array();
        } elseif (!is_array($value)) {
            $value = array($value);
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Get the current value.
     *
     * @param bool $default If set to true the default value will be created.
     *
     * @return mixed
     */
    public function getValue($default = false)
    {
        if ($default && empty($this->value)) {
            $value = array();

            foreach ($this->options as $option) {
                if (isset($option['default'])) {
                    $value[] = $option['value'];
                }
            }

            return $value;
        }

        return $this->value;
    }

    /**
     * Generate the options element.
     *
     * @return string|void
     */
    public function generate()
    {
        $template             = new \FrontendTemplate($this->template);
        $template->options    = $this->options;
        $template->element    = $this;
        $template->tag        = $this->getTag();
        $template->attributes = (array) $this->childAttributes->getAttributes();

        return $template->parse();
    }

    /**
     * Set the template name.
     *
     * @param string $name Name of a Contao template.
     *
     * @return $this
     *
     * @SuppressWarnings(PHPCPD)
     */
    public function setTemplateName($name)
    {
        $this->template = $name;

        return $this;
    }

    /**
     * Get the template name.
     *
     * @return string
     *
     * @SuppressWarnings(PHPCPD)
     */
    public function getTemplateName()
    {
        return $this->template;
    }
}
