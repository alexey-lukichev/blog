<?php 

namespace Core\Templates;

use Entities\View;
use Entities\TelegraphText;

class Swig extends View
{
    public function render(TelegraphText $telegraphText): string
    {
        $swig = file_get_contents(sprintf('templates/%s.swig', $this->templateName));
        foreach ($this->variables as $key) {
            $swig = str_replace('$$'.$key.'$$', $telegraphText->$key, $swig);
        }
        return $swig;
    }
}
