<?php

namespace Netzmacht\Contao\FormHelper\Partial;

use Netzmacht\Contao\FormHelper\Component;
use Netzmacht\Contao\FormHelper\Partial;
use Netzmacht\Contao\FormHelper\HasTemplate;

class TemplateComponent extends Component implements HasTemplate
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @param string $name
     * @return $this
     */
    public function setTemplateName($name)
    {
        $this->template = $name;
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->template;
    }

}