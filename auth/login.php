<?php

if (!isset($_POST['submitted']))
    header('Location: ' . $_SERVER['HTTP_REFERER']);

$credentials = [
    'email' => 'niammuddin@gmail.com',
    'password' => 'admin-radius-2020'
];

if ($credentials['email'] !== $_POST['email'] or $credentials['password'] !== $_POST['password']) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

session_start();

// Storing session data
$_SESSION["isLogged"] = "1";

header('Location:' . '../index.php');

exit();
