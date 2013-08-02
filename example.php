<?php

$pdo = null;

$dev = new Environ(
    'development',
    function () {
        return preg_match('/localhost/', $_SERVER['REQUEST_URI']);
    },
    function () {
        $pdo = new PDO('sqlite:development.db');
    }
);

$prod = new Environ(
    'production',
    function () {
        return true;
    },
    function () {
        $pdo = new PDO('mysql:host=MYHOST;dbname=MYDBNAME', 'MYUSER', 'MYPASSWORD');
    }
);

Environ::init();



$env = Environ::get(); // returns 'development'



Environ::set('production');



if (Environ::is('production')) {
    // This will be executed
}
