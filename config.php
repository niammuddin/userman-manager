<?php
session_start();
if (!isset($_SESSION['isLogged']) or "1" != $_SESSION['isLogged'])
    header('Location: ' . '/login.php');

// mikrotik config
$apiport      = 8728;
$ftpport      = 21;

$ipmikrotik   = 'IP-ADDRESS';
$usermikrotik = 'USERNAME';
$passmikrotik = 'PASSWORD';

// root directory apps
$dir = dirname(__FILE__);
