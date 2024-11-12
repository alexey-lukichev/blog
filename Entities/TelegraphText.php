<?php

namespace Entities;

use DateTime;
use Exception;
use Throwable;

function exceptionHandler(Throwable $exception): void
{
    echo '<div style="border: 2px solid pink; background-color: #fbd6e8; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
    echo $exception->getMessage();
}

set_exception_handler('Entities\exceptionHandler');

class TelegraphText
{
    const FILE_EXTENSION = ".txt";
    private $title, $text, $author, $published, $slug;

    public function setAuthor(string $author): void
    {
        if (strlen($author) > 120) {
            echo 'Длина не может быть больше 120' . PHP_EOL;
            return;
        }
        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setSlug(string $slug): void
    {
        if (!preg_match('/^[A-Za-z0-9-_]/', $slug )) {
            echo 'Некорректная форма записи' . PHP_EOL;
            return;
        }
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setPublished(string $published): void
    {
        $currentDate = new DateTime();
        if ($published <= $currentDate) {
            echo 'Некорректная дата' . PHP_EOL;
            return;
        }
        $this->published = date (format: 'r');
    }

    public function getPublished(): string
    {
        return $this->published;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setText(string $text): void
    {
        if (strlen($text) < 1 || strlen($text) > 500) {
            throw new Exception('Длина текста должна быть от 1 до 500 символов');
        }
        $this->text = $text;
        $this->storeText();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function __set($name, $value): void
    {
        if ($name === 'author') {
            $this->setAuthor($value);
        } elseif ($name === 'slug') {
            $this->setSlug($value);
        } elseif ($name === 'published') {
            $this->setPublished($value);
        } elseif ($name === 'title') {
            $this->setTitle($value);
        } elseif ($name === 'text') {
            $this->setText($value);
            $this->storeText();
        }
    }

    public function __get($name): string|TelegraphText|null
    {
        if ($name === 'author') {
            return $this->getAuthor();
        } elseif ($name === 'slug') {
            return $this->getSlug();
        } elseif ($name === 'published') {
            return $this->getPublished();
        } elseif ($name === 'title') {
            return $this->getTitle();
        } elseif ($name === 'text') {
            return $this->getText($this->loadText($this->slug));
        }
        return null;
    }

    public function __construct(string $title, string $author, string $text)
    {
        $this->title = $title;
        $this->author = $author;
        $this->setText($text);
        $this->published = date (format: 'r');
        $this->slug = str_replace(' ', '-', $this->title);
    }

    private function storeText(): string
    {
       $array = ["text" => $this->text, "title" => $this->title, "author" => $this->author, "published" => $this->published,];
       $newArray = serialize($array);
       file_put_contents($this->slug . self::FILE_EXTENSION, $newArray);
       return $this->slug . self::FILE_EXTENSION;
    }

    private static function loadText(string $slug): ?TelegraphText
    {
        if (file_exists($slug)) {
            $array = unserialize(file_get_contents($slug));
            $title = $array["title"];
            $text = $array["text"];
            $author = $array["author"];
            $published = $array["published"];
            $obj = new TelegraphText($title, $text, $author);
            $obj->published = $published;
            return $obj;
        } else {
            return null;
        }
    }

    public function editText(string $title, string $text): void
    {
        $this->title = $title;
        $this->setText($text);
    }
}
