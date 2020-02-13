<?php
/**
 * @license MIT
 * @author denis909 <dev@denis909.spb.ru>
 * @link http://denis909.spb.ru
 */
namespace Denis909\CascadeFilesystem;

use Yii;

class CascadeLoader
{

    protected static $_namespaces = [];

    public static function addNamespace($namespace, $path)
    {
        static::$_namespaces[$path] = $namespace;
    }

    public static function autoload($class)
    {
        foreach(static::$_namespaces as $path => $namespace)
        {
            $segments = explode("\\", $class);

            $className = array_pop($segments);

            $classNamespace = implode("\\", $segments);

            if ($classNamespace == $namespace)
            {
                $filename = $path . '/' . $className . '.php';

                if (is_file($filename))
                {
                    require_once $filename;
                
                    if (class_exists($class, false))
                    {
                        return true;
                    }

                    if (interface_exists($class, false))
                    {
                        return true;
                    }

                    if (trait_exists($class, false))
                    {
                        return true;
                    }
                }
            }
        }

        return false;
    }

}