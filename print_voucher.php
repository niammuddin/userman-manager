<?php
require_once('function.php');
$API = new RouterosAPI();
$API->debug = false;

if (isset($_GET['comment'])) :

    if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) :


        $user = $API->comm('/tool/user-manager/user/print', array(
            "?comment" => $_GET['comment']
        ));
        $i = 1;
        if ($user) :
            foreach ($user as $row) {
                $vc .= '
                        <table class="voucher" style="margin:0 4px 10px 2px;width: 173px;">
                        <tbody>
                            <tr>
                                <td style="text-align: left; font-size: 14px; font-weight:bold; border-bottom: 1px black solid;">RNET Hotspot<span class="num"> [' . $i++ . ']</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="text-align: center; width: 167px;">
                                        <tbody>
                                            <tr style="color: black; font-size: 11px;">
                                                <td>
                                                    <table style="width:100%;">
                
                                                        <tr>
                                                            <td>kode voucher</td>
                                                        </tr>
                                                        <tr style="color: black; font-size: 14px;">
                                                            <td style="width:100%; border: 2px dashed black; font-weight:bold; border-radius: 2px;">' . $row['username'] . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:100%; border: 1px solid black; font-weight:bold;">' . $row['actual-profile'] . ' Unlimited</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:100%; border: 1px solid black;">login: http://lodan.net</td>
                                                        </tr>
                
                
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                ';
            }

?>


            <!DOCTYPE html>
            <html>

            <head>
                <title>Voucher-<?php echo $_GET['commt']; ?></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta http-equiv="pragma" content="no-cache" />

                <style type="text/css">
                    body {
                        color: #000000;
                        background-color: #FFFFFF;
                        font-size: 14px;
                        font-family: 'Helvetica', arial, sans-serif;
                        margin: 0px;
                        -webkit-print-color-adjust: exact;
                    }

                    table.voucher {
                        display: inline-block;
                        border: 2px solid black;
                        margin: 2px;
                    }

                    @page {
                        size: auto;
                        margin-left: 7mm;
                        margin-right: 3mm;
                        margin-top: 9mm;
                        margin-bottom: 3mm;
                    }

                    @media print {
                        table {
                            page-break-after: auto
                        }

                        tr {
                            page-break-inside: avoid;
                            page-break-after: auto
                        }

                        td {
                            page-break-inside: avoid;
                            page-break-after: auto
                        }

                        thead {
                            display: table-header-group
                        }

                        tfoot {
                            display: table-footer-group
                        }
                    }

                    .num {
                        float: right;
                    }

                    .qrc {
                        width: 30px;
                        height: 30px;
                        margin-top: 1px;
                    }
                </style>
            </head>
            <!-- <body onload="window.print()"> -->

            <body>
                <?php
                echo $vc;
                ?>
            </body>

            </html>
        <?php endif; ?>
    <?php endif; ?>
<?php
    $API->disconnect();
else :
    echo 'paramenter salah';
endif;
?>