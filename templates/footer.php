            <footer class="sticky-footer bg-white">
                <div class="container my-auto right">
                    <div class="copyright text-center my-auto">
                        <span> &copy; 2021</span>
                    </div>
                </div>
            </footer>

            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <i class="fas fa-exclamation-triangle" style="font-size:15px;"></i> Konfirmasi
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                        </div>

                        <form id="logoutform">
                            <div class="modal-body">Tekan "Logout" jika anda ingin mengakhiri session ini.</div>

                            <div class="modal-footer">
                                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">
                                    <i class="fas fa-times-circle fa-fw" style="font-size:13px"></i>
                                    Cancel</button>

                                <button class="btn btn-sm btn-primary" id="submit">
                                    <i class="fas fa-sign-out-alt" style="font-size:12px"></i> Logout
                                </button>
                            </div>


                        </form>

                    </div>



                </div>
            </div>

            </div><!-- content -->
            </div><!-- wrapper -->
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/sb-admin-2.min.js"></script>
            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/dataTables.bootstrap4.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#dataTable').DataTable();
                });
            </script>
            </body>

            </html>