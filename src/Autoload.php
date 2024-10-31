<?php

namespace Retrilhar;

class Autoload
{
    public $dir = __DIR__;

    function init($dir = '')
    {
        if (!empty($dir)) {
            $this->dir = $dir;
        }
        spl_autoload_register([$this, 'spl_autoload_register']);
    }

    function spl_autoload_register($className)
    {
        $parts = explode('\\', $className);
        if (__NAMESPACE__ != array_shift($parts)) {
            return;
        }
        $classPath = $this->dir . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . '.php';

        //$classPath = $this->dir . DIRECTORY_SEPARATOR . end($parts) . '.php';
        if (file_exists($classPath)) {
            include $classPath;
        }
    }
}
