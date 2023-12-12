<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

    </div>
    </div>
        <?php if(isset($page_type) && $page_type == 'login'):?>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <?php endif; ?>
        <?php if(isset($page_type) && $page_type != 'login'):?>
            <footer class="mains-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4 col-xs-12">
            <?php if(isset($_SESSION['login_id']) && isset($_SESSION['roll']) 
            && $_SESSION['roll']==='admin'): ?>      
            <a target="_blank" href="<?=base_url()?>System_Updater" 
       class="btn btnes btn-sm btn-primary">Update System</a>
      <?php endif;?>
       </div>
        <div class="col-md-8 col-xs-12">Copyright &copy; <?=date('Y')?> <strong>Inspire Decor and Builders Pvt Ltd</strong>. All rights reserved
            </div>
            </div>
            </div>
            </div>
            </footer>
           
            <script src="<?=$rurl?>assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/dist/js/custom1.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/datamaps/datamaps.all.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/counterup/waypoints.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/monthly/monthly.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/datamaps/d3.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/datamaps/topojson.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/datamaps/datamaps.all.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/summernote/summernote.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/summernote/summernote.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/datetimepicker/datetimepicker.min.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/touch-table-row-sorter/dist/RowSorter.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/dist/js/custom.js" type="text/javascript"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
            <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="<?=$rurl?>assets/dist/js/utils.js" type="text/javascript"></script>
            <script src="<?=$rurl?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
            <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
            <script src="<?=$rurl?>assets/plugins/notification/push_notification.min.js" type="text/javascript"></script>
            <?php include(APPPATH."views/scriptfiles/footer_script.php"); ?>
            <script src="<?=$rurl?>assets/js/notification.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <script>
                $(".select2").select2();
            </script>
            <?php if(isset($page_type) && $page_type=='income-report' || $page_type=='invoice-report'|| $page_type=='client-report' || $page_type=='custom-income-report' || $page_type=='employee' || $page_type=='client-resource' || $page_type=='custom-client-report' || $page_type=='batch-pdf-invoice-export' || $page_type=='services' || $page_type=='dashboard'){include(APPPATH."views/scriptfiles/chart_view.php");} ?>
        <?php endif;?>
    </body>
</html>