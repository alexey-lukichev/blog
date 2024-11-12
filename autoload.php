<?php

require_once './vendor/autoload.php';

spl_autoload_register(function ($className): void {
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $fileName = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';

    if (file_exists($fileName)) {
        require_once $fileName;
    }
});

function loaderEntities(string $classname): void
{
    if (file_exists(__DIR__ . '/Entities/' . $classname . '.php')) {
        require_once __DIR__ . '/Entities/' . $classname . '.php';
    }
}

function loaderInterfaces(string $classname): void
{
    if (file_exists(__DIR__ . '/Interfaces/' . $classname . '.php')) {
        require_once __DIR__ . '/Interfaces/' . $classname . '.php';
    }
}

spl_autoload_register('loaderEntities');
spl_autoload_register('loaderInterfaces');
