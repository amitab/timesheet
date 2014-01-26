<?php

namespace Database;

class Converter {
    
    private static function get_vars ($o)
    {
        $xary = (array) $o;
        $xarynew = array ();
        foreach ($xary as $k => $v)
        {
            if ($k[0] == "\0")
            {
                // private/protected members have null-delimited prefixes
                // that need to be removed
                $prefix_length = stripos ($k, "\0", 1) + 1;
                $k = substr ($k, $prefix_length, strlen ($k) - $prefix_length);
            }
            
            // recurse through any objects
            if (is_object ($v))
            {
                $v = self::get_vars ($v);
            }
            $xarynew[$k] = $v;
        } 
        return $xarynew;
    }
    
    public static function getArray($data) {
        $container = array();
        foreach($data as $object) {
            $encode = self::get_vars($object);
            if($encode) {
                $container[] = $encode;
            }
            else {
                $GLOBALS['logger']->info('ERROR : ' . print_r($object, 1) );
            }
        }
        return $container;
    }
    
    public static function getSingleArray($object) {
        $container = array();
        $encode = self::get_vars($object);
        if($encode) {
            return $encode;
        }
        else {
            $GLOBALS['logger']->info('ERROR : ' . print_r($object, 1) );
            return false;
        }
    }
    
}