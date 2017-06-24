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

    private $db;

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

        if (!isset($this->db)) {
            throw new Exception('Failed to connect to the database!' . PHP_EOL);
        }
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
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }

    public function db()
    {
        return $this->db;
    }
    
    public function fill($input)
    {
        foreach ($input as $key => $val) {
            $this->{$key} = $val;
        }
    }
    
    public function save()
    {
        print_r(get_object_vars($this));
        return true;
    }
    
    public function delete($type = self::SOFT_DELETE)
    {
        if ($type == self::SOFT_DELETE) {
            $now = date('Y-m-d h:i:s');
            $this->deleted = 1;
            $this->modified_date = $now;
            $this->delete_date = $now;
            $this->save();
            return $this;
        } elseif ($type == self::HARD_DELETE) {
            // run delete from on the database
            return true;
        }
        return false;
    }
}


