<?php
// require_once('../function.php');
$dir = dirname(__FILE__);

// uplaod voucher.rsc
$connId = ftp_connect('36.92.158.39', 21234);
if ($connId) {
    ftp_login($connId, 'radius1', '12345678');
    ftp_pasv($connId, true);
    // $localFilePath  = $dir . '/temp_voucher/' . $comment . '.rsc';
    $localFilePath  = '/Users/niammuddin/MAMP/app_usermanager/temp_voucher/test.txt';
    // $remoteFilePath = $comment . '.rsc';
    $remoteFilePath = 'test.txt';
    if (ftp_put($connId, $remoteFilePath, $localFilePath, FTP_ASCII)) {
        $result = 'success';
    } else {
        $result = 'failed';
    }

    print_r($result);
    print_r($localFilePath);

    ftp_close($connId);
}

// die;

// $API = new RouterosAPI();
// $API->debug = false;

// if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) :

//     $arrID = $API->comm(
//         '/ppp/secret/getall',
//         [
//             '.proplist' => '.id',
//             '?name' => 'zzz1'
//         ]
//     );

//     $API->comm(
//         '/ppp/secret/set',
//         [
//             '.id' => $arrID[0]['.id'],
//             'disabled'  => 'no'
//         ]
//     );

//     die;

//     $array = $API->comm('/tool/user-manager/user/print', [
//         // 'active' => 'true'
//     ]);



//     echo '<pre>';

//     foreach ($array as $row) {
//         print_r($row);
//     }

//     die;


    // $response = $API->comm('/import', array(
    //     'file-name' => 'test1.rsc',
    // ));

    // die;

    // $array = $API->comm('/tool/user-manager/user/print', [
    //     // '' => ''
    // ]);





    // $result = array();
    // foreach ($array as $key => $value) {

    //     // $skill_unique = array_unique($value['comment']);
    //     // $ress[$key] = array_diff($value['comment'], $skill_unique);


    //     if (!in_array($value['comment'], $result)) {

    //         $result[$key] = $value['comment'];
    //     }
    // }

    // echo '<pre>';
    // print_r($result);
    // // print_r($result);


    // die;









    // foreach ($result as $row) {
    //     $comm .= '<option value="/list_user.php?profile=' . $row . '">' . $row . '</option>';
    // }
    // echo $comm;
    // die;

    // echo '</pre>';
    // die;
    // echo '<pre>';
    // print_r($result);

    // die;

    // $offset = 1;
    // $limit = 100;

    // $arr = array_slice($result, $offset * $limit, $limit);

    // echo '<pre>';
    // print_r($arr);




    // // foreach ($arr as $row) {
    // //     echo '<pre>';
    // //     print_r($row);
    // // }


//     $API->disconnect();
// endif;