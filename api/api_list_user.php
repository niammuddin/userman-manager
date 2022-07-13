<?php
require_once('../function.php');
$API = new RouterosAPI();
$API->debug = false;

if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) :

    $comment = isset($_GET['comment']) ? $_GET['comment'] : null;
    $profile = isset($_GET['profile']) ? $_GET['profile'] : null;
    // $profile = '7-HARI';

    if ($comment) {
        $data = ['?comment' => $comment];
    } elseif ($profile) {
        $data = ['?actual-profile' => $profile];
    } else {
        $data = '';
    }
    $users = $API->comm('/tool/user-manager/user/print', $data);



    $datax = array();
    $no = isset($_POST['start']) ? $_POST['start'] : NULL;
    foreach ($users as $row) {
        $no++;
        $rows = array();
        $rows[] = $no;
        $rows[] = $row['username'];
        $rows[] = $row['actual-profile'];
        $rows[] = $row['comment'];
        $datax[] = $rows;
    }


    $output = array(
        "draw" => isset($_POST['draw']) ? $_POST['draw'] : NULL,
        "recordsTotal" => count($datax),
        "recordsFiltered" => count($datax),
        "data" => $datax,
    );
    echo json_encode($output);


    $API->disconnect();
endif;
