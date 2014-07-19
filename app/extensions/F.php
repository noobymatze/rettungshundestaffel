<?php

class F {

    public static function compose($f, $g) 
    {
        return function ($x) use ($f, $g)
        {
            return $f($g($x));
        };
    }

    public static function get($name) 
    {
        return function ($obj) use ($name) 
        {
            if(is_array($obj)) {
                return $obj[$name];
            }

            return $obj->$name;
        };
    }

}