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

			$classNamespaceAlias = '@' . str_replace("\\", '/', $classNamespace);

			if ($classNamespaceAlias == $namespace)
			{
                $filename = $path . '/' . $className . '.php';

				if (is_file($filename))
				{
					require_once $filename;

					$exists = class_exists($class, false) || interface_exists($class, false) || trait_exists($class, false);	
				
					if ($exists)
					{
						return true;
					}
				}				
			}
		}

		return false;
	}

}