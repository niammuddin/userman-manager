<?php
$pages = basename(__FILE__);
include('templates/header.php');
require_once('function.php');
$API = new RouterosAPI();
$API->debug = false;

if ($API->connect($ipmikrotik, $usermikrotik, $passmikrotik)) {
    $resProfile = $API->comm('/tool/user-manager/profile/print');
    foreach ($resProfile as $row) {
        $profile .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
    }
    $API->disconnect();
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 order-xl-4">
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-user" style="font-size:13px;"></i> Create Users</h6>
                </div>
                <div class="card-body">

                    <form id="GenVoucher" method="post">
                        <div class="col-sm-12 mb-3 mb-sm-0">

                            <div class="form-group">
                                <label for="qty"><i class="fas fa-ethernet fa-fw"></i> Quantity :</label>
                                <input type="number" class="form-control" name="qty" placeholder="Quantity voucher" required>
                            </div>

                            <div class="form-group">
                                <label for="user"><i class="fas fa-server fa-fw"></i> User Mode :</label>
                                <select name="user" class="custom-select input-sm" required>
                                    <option value="vc">Username=Password</option>
                                    <option value="up">Username&Password</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="profile"><i class="fas fa-server fa-fw"></i> Profile :</label>
                                <select name="profile" class="custom-select input-sm" required>
                                    <!-- <option value="24-JAM">24-JAM</option> -->
                                    <?php echo $profile ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="userl"><i class="fas fa-server fa-fw"></i> User Length :</label>
                                <select name="userl" class="custom-select input-sm" required>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="prefix"><i class="fas fa-ethernet fa-fw"></i> Prefix :</label>
                                <input type="text" class="form-control" name="prefix" placeholder="prefix_">
                            </div>


                            <div class="form-group">
                                <label for="char"><i class="fas fa-server fa-fw"></i> Character :</label>
                                <select name="char" class="custom-select input-sm" required>
                                    <option value="mix">Random Lower</option>
                                    <option value="num">123456</option>
                                    <option value="mix1">Random Uppercase</option>
                                    <option value="mix2">Random Upper/Lower</option>
                                </select>
                            </div>

                            <div class="beforeSend mb-4" id="result" role="alert"></div>

                        </div>
                        <div class="modal-footer">
                            <span id="printing"></span>
                            <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-undo"></i> Reset</button>
                            <button class="btn btn-sm btn-primary" id="action"><i class="fas fa-paper-plane"></i> Generate</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <div class="col-xl-4 order-xl-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-info-circle" style="font-size:13px;"></i> Last Generate</h6>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>

    </div>
</div>
</div><!-- content -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#GenVoucher').submit(function(e) {
            e.preventDefault();
            $('#action').html('<i class="fas fa-spinner fa-pulse fa-fw"></i> Process');
            $('#printing').html('');
            $.ajax({
                type: "POST",
                url: '/api/api_add_user.php',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.beforeSend').html('<div class="card mb-4 border-left-primary"><div class="card-body"><i class="fas fa-spinner fa-spin fa-fw"></i> Mohon Tunggu,...</div></div>');
                },
                success: function(data) {
                    if (data.result === "success") {
                        console.log("Debug: " + data.message + "");
                        $('#result').html('<div class="card mb-4"><div class="card-body"><i class="text-success fas fa-check-circle"></i> <b>Sukses : </b>' + data.qty + ' voucher berhasil digenerate.</div></div>');
                        $('#printing').html('<a target="_blank" class="btn btn-sm btn-primary" href="print_voucher.php?comment=' + data.comments + '"><i class="fas fa-print"></i> Print</a>');
                        $('#action').html('<i class="fas fa-paper-plane"></i> Generate');
                    } else {
                        console.log("Debug: " + data.message + "");
                        $('#result').html('<div class="card mb-4"><div class="card-body"><i class="text-danger fas fa-info-circle"></i> <b>Error : </b>' + data.message + '</div></div>');
                        $('#action').html('<i class="fas fa-paper-plane"></i> Generate');
                    }
                },
                error: function(data) {
                    console.log("Debug: Gagal membuat voucher");
                    $('#result').html('<div class="card mb-4"><div class="card-body"><i class="text-danger fas fa-info-circle"></i> <b>Error:</b> Gagal membuat voucher</div></div>');
                    $('#action').html('<i class="fas fa-paper-plane"></i> Generate');
                }
            });
        });
    });
</script>


<?php include('templates/footer.php'); ?>