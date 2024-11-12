<?php 

namespace Core\Templates;

use Entities\View;
use Entities\TelegraphText;

class Spl extends View
{
    public function render(TelegraphText $telegraphText): string
    {
        $spl = file_get_contents(sprintf('templates/%s.spl', $this->templateName));
        foreach ($this->variables as $key) {
            $spl = str_replace('$$'.$key.'$$', $telegraphText->$key, $spl);
        }
        return $spl;
    }
}
