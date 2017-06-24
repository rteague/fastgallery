<?php

/**
 * cli.php
 * by rashaud
 * Sun June 18 2017
 *
 */

require 'vendor/autoload.php';

require 'dbconfig.php';

// models
spl_autoload_register(function ($classname) {
    require ('models/' . $classname . '.php');
});

// controllers
spl_autoload_register(function ($classname) {
    require ('controllers/' . $classname . '.php');
});

$a = new Account;
$a->save();
//echo $a . PHP_EOL;

