<?php

/**
 * cli.php
 * by rashaud
 * Sun June 18 2017
 *
 */

// models
spl_autoload_register(function ($classname) {
    require ('models/' . $classname . '.php');
});

// controllers
spl_autoload_register(function ($classname) {
    require ('controllers/' . $classname . '.php');
});

$a = new Account;

print $a->delete(Account::HARD_DELETE);

