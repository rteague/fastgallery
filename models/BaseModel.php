<?php

/**
 * BaseModel.php
 * by rashaud
 * Wed June 21 2017
 *
 */

use \Doctrine\DBAL\DriverManager;

class BaseModel
{
    const DEFAULT_DB_PREFIX = 'fg_';
    const SOFT_DELETE = 0;
    const HARD_DELETE = 1;

    protected $db;

    public function __construct()
    {
        // connect to the database
        $dbconfig = new \Doctrine\DBAL\Configuration();
        $mysql_url_str = sprintf(
            'mysql://%s:%s@%s/%s',
            DB_USER,
            DB_PASS,
            DB_HOST,
            DB_DATABASE
        );
        $this->db = \Doctrine\DBAL\DriverManager::getConnection(
            ['url' => $mysql_url_str],
            $dbconfig
        );
    }

    public function __destruct()
    {
        $this->db->close();
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


