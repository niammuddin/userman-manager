<?php
require_once('../function.php');
$API = new RouterosAPI();
$API->debug = false;

if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) {
    $resProfile = $API->comm('/tool/user-manager/profile/print');
    foreach ($resProfile as $row) {
        $profile .= '<option value="/list_user.php?profile=' . $row['name'] . '">' . $row['name'] . '</option>';
    }

    // comments
    $array = $API->comm('/tool/user-manager/user/print');
    $result = array();
    foreach ($array as $key => $value) {
        if (!in_array($value['comment'], $result))
            $result[$key] = $value['comment'];
    }
    foreach ($result as $row) {
        $comments .= '<option value="/list_user.php?comment=' . $row . '">' . $row . '</option>';
    }


    header('Content-type:application/json');
    $output = array(
        'result' => 'success',
        'profile' => '<div class="col-sm-3 mb-3 mb-sm-0"><select class="custom-select input-sm" onchange="location = this.value;" title="Filter by Profile"><option>Filter Profiles</option><option value="list_user.php">All</option>' . $profile . '</select></div>',
        'comment' => '<div class="col-sm-3 mb-3 mb-sm-0"><select class="custom-select input-sm" onchange="location = this.value;" title="Filter by comments"><option>Filter Comments</option><option value="list_user.php">All</option>' . $comments . '</select></div>'
    );
    echo json_encode($output);



    $API->disconnect();
}
