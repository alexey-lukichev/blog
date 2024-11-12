<?php
date_default_timezone_set("Europe/Moscow");

use Entities\TelegraphText;
use Core\Templates\Spl;

require_once './autoload.php';

// $telegraphText = new TelegraphText('Заголовок', 'Сергей', 'Какой-то текст');
// $telegraphText->editText('Измененный заголовок', 'Измененный текст');
// $slug = $telegraphText->storeText();
// $loadText = TelegraphText::loadText($slug);
// var_dump($loadText);
// echo $loadText->title;
// $loadText->editText('Значение отличное от изначального', 'И еще раз значение отличное от изначальных');
// $slug = $loadText->storeText();
// $loadText = TelegraphText::loadText($slug);
// var_dump($telegraphText);
// var_dump($loadText);

// $fileStorage = new FileStorage;
// $fileStorage->list($slug);
// print_r($fileStorage->list($slug));

$telegraphText = new TelegraphText('Title', 'Vasya', 'Some text');
$telegraphText->editText('Some title', 'Some text');
var_dump($telegraphText);

// $swig = new Swig('telegraph_text');
// $swig->addVariablesToTemplate(['slug', 'text']);

$view = new Spl('telegraph_text');
$view->addVariablesToTemplate(['slug', 'title', 'text']);

echo $view->render($telegraphText);

// $templateEngines = [$swig, $spl];
// foreach ($templateEngines as $engine) {
//     if ($engine instanceof IRender) {
//         echo $engine->render($telegraphText) . PHP_EOL;
//     } else {
//         echo 'Template engine does not support render interface' . PHP_EOL;
//     }
// }
