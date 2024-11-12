<?php

namespace Entities;

use Interfaces\IRender;

abstract class View implements IRender
{
    protected $templateName;
    protected $variables = [];
    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }
    public function addVariablesToTemplate(array $variables): void
    {
        $this->variables = $variables;
    }

    public function render(TelegraphText $telegraphText): string
    {
        return '';
    }
}
