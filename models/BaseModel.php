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
        'db',
        'id_field',
        'onSaveID',
        'queryStr',
        'reserved_properties',
        'table_name',
        'transactionProperties',
    ];

    protected $db;
    
    protected $onSaveID;

    protected $queryStr;

    protected $transactionProperties;
    
    protected $table_name;

    public function __construct()
    {
        // connect to the database
        $dbconfig = new \Doctrine\DBAL\Configuration();
        $mysql_url_str = sprintf(
            'mysql://%s:%s@%s/%s',
            DB_USER,
            DB_PASSWORD,
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

    protected function getTableColumns()
    {
        if (empty($this->table_name)) {
            return null;
        }
        $columns = [];
        $sql = sprintf("show columns from %s", $this->table_name);
        $stmt = $this->db->executeQuery($sql);
        $columns = $stmt->fetchAll();
        return $columns;
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

    public function buildQueryStr()
    {
        if (isset($this->{$this->id_field})) {
            // $id passed, so it's an update
            $sql = sprintf("update %s set ", $this->table_name);
        } else {
            // $id not passed, so it's an insert
            $sql = sprintf("insert into %s set ", $this->table_name);
        }
        $properties = get_object_vars($this);
        $this->transactionProperties = array_filter($properties, function($val, $key) {
           if (
                preg_match('/object|resource|unknown *type/i', gettype($val))
                || in_array($key, $this->reserved_properties)
                || $key == $this->id_field
            ) {
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);
        foreach ($this->transactionProperties as $key => $val) {
            // fields to update
            if (self::NULL_PROPERTIES && is_null($val)) {
                $sql = sprintf("%s%s = null, ", $sql, $key, $val);
            } else {
                $sql = sprintf("%s%s = :%s, ", $sql, $key, $key);
            }
        }
        $sql = trim($sql, ', ');
        if (isset($this->onSaveID)) {
            $sql = sprintf("%s where %s = '%s'", $sql, $this->id_field, $this->onSaveID);
        }
        $this->queryStr = $sql;
        return $this->queryStr;
    }

    public function save()
    {
        $this->buildQueryStr();
        
        if (!$this->beforeSave()) {
            throw new Exception('Before save failed' . PHP_EOL);
        }
        
        echo $this->queryStr . PHP_EOL;
        
        // now prepare run the query
        $stmt = $this->db->prepare($this->queryStr);
        foreach ($this->transactionProperties as $key => $val) {
            $stmt->bindValue(sprintf(':%s', $key), $val);
        }
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
            $this->save($this->{$this->id_field});
            return $this;
        } elseif ($type == self::HARD_DELETE) {
            // run delete from on the database
            return true;
        }
        return false;
    }
}


