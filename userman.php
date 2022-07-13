<?php
// $pages = basename(__FILE__);
require_once('function.php');
$API = new RouterosAPI();
$API->debug = false;

if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) {

    $userid = $API->comm('/tool/user-manager/user/add', array(
        'customer'      => 'admin',
        'username'      => 'test123',
        'password'      => 'test123',
        'shared-users'  => 1,
        'comment'  => $commt
    ));
    // add profile
    if (!empty($userid)) {
        $API->comm('/tool/user-manager/user/create-and-activate-profile', array(
            'customer'      => 'admin',
            'numbers'      => $userid,
            'profile'      => 'PAKET-3JAM'
        ));
    }

    // remove username/voucher userman
    // $ARRAY2 = $API->comm("/tool/user-manager/user/remove", [
    //     "numbers" => '*7'
    // ]);


    // print_r($ARRAY2);
    // print_r($userid);

    $API->disconnect();
}
