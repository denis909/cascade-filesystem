<?php

namespace Denis909\CascadeFilesystem;

class CascadeFilesystem
{

    protected static $_paths = [];

    public static function findFiles(string $file)
    {
        $return = [];
    
        foreach(static::$_paths as $path)
        {
            $filename = $path .'/' . $file;

            if (is_file($filename))
            {
                $return[] = $filename;
            }
        }

        return $return;
    }

    public static function addPath(string $path)
    {
        if (array_search($path, static::$_paths) === false)
        {
            $this->_paths[] = $path;
        }
    }

    public static function requireOnce(string $file)
    {
        $files = static::findFiles($file);

        foreach($files as $filename)
        {
            require_once($filename);
        }
    }

    public static function require(string $file)
    {
        $files = static::findFiles($file);

        foreach($files as $filename)
        {
            require($filename);
        }
    }

    public static function mergeContent(string $file, string $devider = "\n")
    {
        $return = '';

        $files = static::findFiles($file);

        $i = 0;

        foreach($files as $filename)
        {
            if ($i > 0)
            {
                $return .= $devider;
            }

            $return .= file_get_contents($filename);

            $i++;
        }
        
        return $return;
    }

}