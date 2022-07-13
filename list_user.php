<?php
require_once('function.php');
$pages = basename(__FILE__);
include('templates/header.php');

if (isset($_GET['profile']) ? $_GET['profile'] : NULL) {
    $filters = '?profile=' . (isset($_GET['profile']) ? $_GET['profile'] : NULL);
} elseif (isset($_GET['comment']) ? $_GET['comment'] : NULL) {
    $filter = (isset($_GET['comment']) ? $_GET['comment'] : NULL);
    $filters = '?comment=' . (isset($_GET['comment']) ? $_GET['comment'] : NULL);
}
?>

<div class="container-fluid">

    <div class="form-group row">

        <div class="col-sm-3 mb-3 mb-sm-0">
            <select id="profile" class="custom-select input-sm" onchange="location = this.value;" title="Filter by Profile">
                <option>Filter Profiles</option>
            </select>
        </div>

        <div class="col-sm-3">
            <select id="comment" class="custom-select input-sm" onchange="location = this.value;" title="Filter by comments">
                <option>Filter comments</option>
            </select>
        </div>

        <?php if ($filters == '?comment=' . (isset($_GET['comment']) ? $_GET['comment'] : NULL)) : ?>
            <div class="col-sm">
                <form id="hapus_users" method="post">
                    <input type="hidden" name="comment" value="<?php echo $filter ?>">
                    <a target="_blank" class="btn btn-sm btn-primary mr-2 mt-1" href="print_voucher.php<?php echo $filters ?>"><i class="fas fa-print"></i> Print</a>
                    <span class="result"><button id="action" class="btn btn-sm btn-danger mt-1"><i class="fas fa-trash"></i> Delete By Comments</button></span>
                </form>
            </div>
        <?php endif; ?>



    </div>

    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-cloud" style="font-size:13px;"></i> List Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="list_users" class="table table-striped" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <th>No</th>
                        <th>Username</th>
                        <th>Profiles</th>
                        <th>Comments</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</div><!-- content -->








<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: '/api/api_get_filter.php',
            success: function(data) {
                if (data.result === "success") {
                    $('#profile').html('' + data.profile + '');
                    $('#comment').html('' + data.comment + '');
                }
            },
        });
    });


    $(document).ready(function() {
        $('#hapus_users').submit(function(e) {
            e.preventDefault();
            $('#action').html('<i class="fas fa-spinner fa-spin fa-fw"></i> Deleting...');
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "/api/api_delete_user.php",
                data: $(this).serialize(),
                success: function(data) {
                    if (data.result === 'success') {
                        console.log("Debug: " + data.message + "");
                        $('.result').html('<button class="btn btn-sm btn-success mt-1"><i class="far fa-check-circle"></i> Success Deleted</button>');
                        // $('#list_users').DataTable().ajax.reload();
                        setTimeout(function() {
                            window.location.href = '/list_user.php';
                        }, 0);
                    } else {
                        console.log("Debug: " + data.message + "");
                        $('.result').html('<i class="fas fa-times"></i> ' + data.message + '');
                    }
                },
                error: function(data) {
                    console.log("Debug: Failed to Delete");
                    $('.result').html('<i class="fas fa-times"></i> Failed to Delete');
                }

            });
        });
    });

    $(document).ready(function() {
        $('#list_users').dataTable({
            "bProcessing": true,
            // "bServerSide": true,
            "sAjaxSource": "/api/api_list_user.php<?php echo $filters; ?>"
        });
    });
</script>





<?php include('templates/footer.php'); ?>