<?php

/**
 * Account.php
 * by rashaud
 * Wed June 21 2017
 *
 */

class Account extends BaseModel {
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


