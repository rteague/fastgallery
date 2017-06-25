<?php

/**
 * Account.php
 * by rashaud
 * Wed June 21 2017
 *
 */

class Account extends BaseModel {
    protected $table_name = 'accounts';
    protected $id_field = 'id';

    public $id;
    public $modified_by;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $permissions;
    public $status;
    public $deleted;
    public $create_date;
    public $modified_date;
    public $delete_date;
    
    public static function upsert($input, $id = null)
    {
        $account  = null;
        if (is_null($id)) {
            $account = new Account;
        } else {
            $account = Account::findById($id);
        }
        
        $account->save();
        
        return $account;
    }
    
    public static function getAllFiltered($filter)
    {
        return [];
    }

    public static function findById($id)
    {
       return []; 
    }

    
}


