<?php
require_once('config.php');
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
// echo set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('vendor/phpseclib/Net/SSH2.php');

$ssh = new Net_SSH2($ipmikrotik);
$ssh->login($usermikrotik, $passmikrotik) or die("Login failed");
// echo $ssh->exec('/ip addr pr');
