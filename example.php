<?php

// (replace with composer autoload)
include('src/Environ/Environ.php');
include('src/Environ/Environment.php');

// Instantiation
$environ = new Environ\Environ();

// Let's declare a first environment...
$environ->add(
    'development',
    function () {
        return (preg_match('/localhost/', $_SERVER['REQUEST_URI']) !== false);
    },
    function () {
        $pdo = new PDO('sqlite:development.db');
    }
);

// ...and then another
$environ->add(
    'production',
    function () {
        return true; // we want it to be chosen by default if no other environment fits
    },
    function () {
        $pdo = new PDO('mysql:host=MYHOST;dbname=MYDBNAME', 'MYUSER', 'MYPASSWORD');
    }
);

// This browses the environment we just declared and selects the first one which condition returns true
$environ->init();

// Assuming we're working on localhost, this will print 'development'
echo($environ->get().'<br />');

// Want to try grown-up stuff ?
$environ->set('production');

if ($environ->is('production')) {
    echo('That\'s the stuff'); // This will be printed out
}
