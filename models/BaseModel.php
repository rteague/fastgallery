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
    // will save null properties as null to the database in inserts and updates
    const NULL_PROPERTIES = true;

    // reserved properties for the base class
    protected $reserved_properties = [
        'reserved_properties',
        'table_name',
        'id_field',
        'db',
    ];

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

    protected function beforeSave()
    {
        return true;
    }
    
    protected function afterSave()
    {
        return true;
    }
    
    public function save($id = null)
    {
        if (!$this->beforeSave()) {
            throw new Exception('Before save failed' . PHP_EOL);
        }
        if (isset($id)) {
            // $id passed, so it's an update
            $sql = sprintf("update %s set ", $this->table_name);
        } else {
            // $id not passed, so it's an insert
            $sql = sprintf("insert into %s set ", $this->table_name);
        }
        $type;
        $properties = get_object_vars($this);
        $sql_vals = [];
        /*
        foreach ($properties as $key => $val) {
            $type = gettype($val);
            if (
                preg_match('/object|resource|unknown *type/i', $type)
                || in_array($key, $this->reserved_properties)
                || ($key == $this->id_field)
            ) {
                continue;
            }
            //
        }
        */
        $properties = array_filter($properties, function($key, $val) {
            if (
                preg_match('/object|resource|unknown *type/i', gettype($val))
                || in_array($key, $this->reserved_properties)
                || $key == $this->id_field
            ) {
                return true;
            }
        });
        die(var_dump($properties).PHP_EOL);
        // fields to update
        if (self::NULL_PROPERTIES && is_null($val)) {
            $sql = sprintf("%s%s = null, ", $sql, $key, $val);
        } else {
            $sql = sprintf("%s%s = :%s, ", $sql, $key, $key);
        }
        //echo sprintf("%s type:%s", $key, $type) . PHP_EOL;
        $sql = trim($sql, ', ');
        
        if (isset($id)) {
            $sql = sprintf("%s where %s = '%s'", $sql, $this->id_field, $id);
        }
        echo $sql . PHP_EOL;
        
        // now prepare run the query
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('%s', $val);
        $stmt->execute();
        
        if (!$this->afterSave()) {
            throw new Exception('After save failed' . PHP_EOL);
        }
        
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


