<?php
/**
 * @license MIT
 * @author denis909 <dev@denis909.spb.ru>
 * @link http://denis909.spb.ru
 */
namespace Denis909\CascadeFilesystem;

class CascadeConfig extends CascadeFilesystem
{

    public static function mergeConfig(string $file, array $return = [])
    {
        $files = static::findFiles($file);

        foreach($files as $filename)
        {
            $return = static::mergeArray($return, require $filename);
        }

        return $return;
    }

    public static function mergeArray(array $a, array $b)
    {
        foreach ($b as $k => $v)
        {
            if (is_int($k))
            {
                if (array_key_exists($k, $a))
                {
                    $a[] = $v;
                }
                else
                {
                    $a[$k] = $v;
                }
            }
            elseif (is_array($v) && isset($a[$k]) && is_array($a[$k]))
            {
                $a[$k] = static::mergeArray($a[$k], $v);
            }
            else
            {
                $a[$k] = $v;
            }
        }

        return $a;
    }

}