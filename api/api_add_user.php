<?php
require_once('../function.php');
$API = new RouterosAPI();
$API->debug = false;

if (isset($_POST['qty'])) {
    $qty = ($_POST['qty']);
    $user = ($_POST['user']);
    $userl = ($_POST['userl']);
    $profile = ($_POST['profile']);
    if ($profile == '30-HARI') {
        $prefix = '30d';
    } elseif ($profile == '7-HARI') {
        $prefix = '7d';
    } else {
        $prefix = ($_POST['prefix']);
    }
    $char = ($_POST['char']);
    $comment = $user . '-' . $qty . '-' . date('m.d.y-H.i.s');


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
            $voc .= 'add customer="admin" disabled="no" username="' . $u[$i] . '" password="' . $u[$i] . '" shared-users="1" comment="' . $comment . '"' . PHP_EOL .
                'create-and-activate-profile "' . $u[$i] . '" customer="admin" profile="' . $profile . '"' . PHP_EOL;
        }
        $file = fopen($dir . '/temp_voucher/' . $comment . '.rsc', 'w');
        fwrite($file, '/tool user-manager user' . PHP_EOL . $voc . PHP_EOL . ':delay 5' . PHP_EOL . '/file remove ' . $comment . '.rsc');
        fclose($file);
        // selesai bikin voucher.rsc


        // uplaod voucher.rsc
        $connId = ftp_connect($ipmikrotik, $ftpport);
        if ($connId) {
            ftp_login($connId, $usermikrotik, $passmikrotik);
            ftp_pasv($connId, true);
            $localFilePath  = $dir . '/temp_voucher/' . $comment . '.rsc';
            $remoteFilePath = $comment . '.rsc';
            if (ftp_put($connId, $remoteFilePath, $localFilePath, FTP_ASCII)) {
                $result = 'success';
            } else {
                $result = 'failed';
            }
            ftp_close($connId);
            // hapus file vc-xxx.rsc
            unlink($dir . '/temp_voucher/' . $comment . '.rsc');
        } else {
            header('Content-type:application/json');
            $result = array(
                'result' => 'error',
                'message' => 'tidak bisa terhubung ke server'
            );
            echo json_encode($result);
            // hapus file vc-xxx.rsc
            unlink($dir . '/temp_voucher/' . $comment . '.rsc');
            die;
        }

        // jika upload ke mikrotik sukses akan melakukan import file vc-xxx.rsc
        if ($result == 'success') {
            if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) {
                $response = $API->comm('/import', array(
                    'file-name' => $comment . '.rsc',
                ));
                // // delay 5 detik
                // sleep(3);
                // // mencari id files
                // $response = $API->comm('/file/print', array(
                //     '?name' =>  $comment . '.rsc'
                // ));
                // // menghapus files berdasarkan id files
                // $response = $API->comm('/file/remove', array(
                //     '.id' => $response[0]['.id'],
                // ));
                $API->disconnect();
            }
            header('Content-type:application/json');
            $result = array(
                'result' => 'success',
                'message' => 'Voucher berhasil digenerate',
                'comments' => $comment,
                'qty' => $qty
            );
            echo json_encode($result);
        } else {
            header('Content-type:application/json');
            $result = array(
                'result' => 'error',
                'message' => 'terjadi kesalahan!'
            );
            echo json_encode($result);
        }
    }
} else {
    header('Content-type:application/json');
    $result = array(
        'result' => 'error',
        'message' => 'error'
    );
    echo json_encode($result);
}
