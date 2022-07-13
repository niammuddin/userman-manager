<?php
require_once('../function.php');
$API = new RouterosAPI();
$API->debug = false;

if (isset($_POST['comment']) ? $_POST['comment'] : NULL) {

    $comment = ($_POST['comment']);

    if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) :

        $array = $API->comm('/tool/user-manager/user/print', [
            '?comment' => $comment
        ]);

        foreach ($array as $row) {
            $voc .= '/tool user-manager user remove "' . $row['username'] . '"' . PHP_EOL;
        }

        $file = fopen($dir . '/temp_voucher/' . $comment . '.rsc', 'w');
        fwrite($file, $voc . PHP_EOL . ':delay 5' . PHP_EOL . '/file remove ' . $comment . '.rsc');
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
                header('Content-type:application/json');
                $result = array(
                    'result' => 'success',
                    'message' => 'Voucher berhasil dihapus',
                    'comments' => $comment
                );
                echo json_encode($result);
                $API->disconnect();
            }
        } else {
            header('Content-type:application/json');
            $result = array(
                'result' => 'error',
                'message' => 'terjadi kesalahan!'
            );
            echo json_encode($result);
        }
        $API->disconnect();
    endif;
}
