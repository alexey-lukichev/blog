<?php 

namespace Entities;

require_once 'Storage.php';

class FileStorage extends Storage
{
    // public string $searchRoot = 'D:\xampp\htdocs\welcome\php-developer-base\Module-9';
    const DIR = __DIR__;
    public function create(TelegraphText $telegraphText): string
    {
        $slug = self::DIR . '/' . $telegraphText->getSlug() . '_' . date(format: 'Y-m-d_H-i-s');
        if (file_exists($slug)) {
            $i = 1;
            while (file_exists($slug . '_' . $i)) {
                $i++;
            }
            $slug .= '_'. $i;
        }
        $slug = $telegraphText->getSlug();
        file_put_contents($slug, serialize($telegraphText));
        return $slug;
    }

    public function read(string $slug): ?TelegraphText
    {
        if (file_exists($slug)) {
            $file = unserialize(file_get_contents($slug));
            return $file;
        }
        return null;
    }

    public function update(string $slug, TelegraphText $telegraphText): bool
    {
        if (file_exists($slug)) {
            file_put_contents($slug, serialize($telegraphText));
            return true;
        }
        return false;
    }

    public function delete(string $slug): bool
    {
        if (file_exists($slug)) {
            unlink($slug);
            return true;
        }
        return false;
    }

    public function list(string $slug): array
    {
        $listArray = [];
        $files = scandir(self::DIR);
        unset($files[0], $files[1]);
        foreach ($files as $file) {
            if (is_file($file)) {
                $listArray[] = unserialize(file_get_contents($slug));
            }
        }
        return $listArray;
    }
}
