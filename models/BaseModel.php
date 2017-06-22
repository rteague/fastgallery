<?php

/**
 * BaseModel.php
 * by rashaud
 * Wed June 21 2017
 *
 */

class BaseModel
{
    const SOFT_DELETE = 0;
    const HARD_DELETE = 1;
    
    public function __construct()
    {
        //
    }
    
    public function __toString()
    {
        return var_export($this, true) . PHP_EOL;
    }
    
    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }
    
    public function fill($input)
    {
        foreach ($input as $key => $val) {
            $this->{$key} = $val;
        }
    }
    
    public function save()
    {
        return true;
    }
    
    public function delete($type = self::SOFT_DELETE)
    {
        echo $type, PHP_EOL;
    }
}


