<?php
// date_default_timezone_set("Asia/Jakarta");
date_default_timezone_set($_SESSION['timezone']);
require_once('../include/routeros_api.class.php');
$API = new RouterosAPI();
$API->debug = false;


function randN($length)
{
    $chars = "23456789";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randUC($length)
{
    $chars = "ABCDEFGHJKLMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}
function randLC($length)
{
    $chars = "abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randULC($length)
{
    $chars = "ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNLC($length)
{
    $chars = "23456789abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNUC($length)
{
    $chars = "23456789ABCDEFGHJKLMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNULC($length)
{
    $chars = "23456789ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

if ($API->connect('45.84.58.132', 'subnetid', 'lodan2020')) {

    // $resProfile = $API->comm('/tool/user-manager/profile/print');
    // foreach ($resProfile as $row) {
    //     $profile .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
    // }

    if (isset($_POST['qty'])) {
        $qty = ($_POST['qty']);
        $user = ($_POST['user']);
        $userl = ($_POST['userl']);
        $prefix = ($_POST['prefix']);
        $char = ($_POST['char']);
        $profileadd = ($_POST['profile']);
        $commt = $user . '-' . date('m.d.y-H.i.s');


        if ($user == "vc") {
            $shuf = ($userl - $a[$userl]);
            for ($i = 1; $i <= $qty; $i++) {
                if ($char == "lower") {
                    $u[$i] = randLC($shuf);
                } elseif ($char == "upper") {
                    $u[$i] = randUC($shuf);
                } elseif ($char == "upplow") {
                    $u[$i] = randULC($shuf);
                }
                if ($userl == 3) {
                    $p[$i] = randN(1);
                } elseif ($userl == 4 || $userl == 5) {
                    $p[$i] = randN(2);
                } elseif ($userl == 6 || $userl == 7) {
                    $p[$i] = randN(3);
                } elseif ($userl == 8) {
                    $p[$i] = randN(4);
                }

                $u[$i] = "$prefix$u[$i]$p[$i]";

                if ($char == "num") {
                    if ($userl == 3) {
                        $p[$i] = randN(3);
                    } elseif ($userl == 4) {
                        $p[$i] = randN(4);
                    } elseif ($userl == 5) {
                        $p[$i] = randN(5);
                    } elseif ($userl == 6) {
                        $p[$i] = randN(6);
                    } elseif ($userl == 7) {
                        $p[$i] = randN(7);
                    } elseif ($userl == 8) {
                        $p[$i] = randN(8);
                    }

                    $u[$i] = "$prefix$p[$i]";
                }
                if ($char == "mix") {
                    $p[$i] = randNLC($userl);


                    $u[$i] = "$prefix$p[$i]";
                }
                if ($char == "mix1") {
                    $p[$i] = randNUC($userl);


                    $u[$i] = "$prefix$p[$i]";
                }
                if ($char == "mix2") {
                    $p[$i] = randNULC($userl);


                    $u[$i] = "$prefix$p[$i]";
                }
            }

            for ($i = 1; $i <= $qty; $i++) {
                $response = $API->comm("/tool/user-manager/user/add", array(
                    "customer"      => "admin",
                    "username"      => $u[$i],
                    "password"      => $u[$i],
                    "shared-users"  => 1,
                    "comment"  => $commt
                ));
                // add profile
                if (!empty($response)) {
                    $API->comm("/tool/user-manager/user/create-and-activate-profile", array(
                        "customer"      => "admin",
                        "numbers"      => $response,
                        "profile"      => $profileadd
                    ));
                }
            }
        }
        header('Content-type:application/json');
        $result = array(
            'result' => 'success',
            'message' => 'Berhasil generate voucher',
            'comments' => $commt,
            'qty' => $qty
        );
        echo json_encode($result);
    } else {
        header('Content-type:application/json');
        $result = array(
            'result' => 'error',
            'message' => 'Terjadi kesalahan!'
        );
        echo json_encode($result);
    }
} else {
    header('Content-type:application/json');
    $result = array(
        'result' => 'error',
        'message' => 'connection timeout'
    );
    echo json_encode($result);
}
$API->disconnect();
