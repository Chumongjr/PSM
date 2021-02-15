<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Debtor Profile </h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('<i class="fa fa-step-backward"></i> List of Debtors', ['/debtors/index'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Company</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Debtor Code</strong>

                        <p class="text-muted">
                            <?php echo $debdet[0]; ?>
                        </p>

                        <hr>
                        <strong><i class="fas fa-building mr-1"></i> Debtor Name</strong>

                        <p class="text-muted">
                            <?php echo $debdet[1]; ?>
                        </p>

                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">
                            <span> Address   : <?php echo $debdet[2]; ?></span> <br>
                            <span> Telephone : <?php echo $debdet[3]; ?></span> <br>
                            <span> Email     : <?php echo $debdet[4]; ?></span>
                        </p>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="../web/dist/img/user-img.jpg"
                                 alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?php echo $debdet[5]; ?></h3>

                        <p class="text-muted text-center">Contact Person</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Phone No :</b> <a class="float-right"><?php echo $debdet[6]; ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Invoice Period :</b> <a class="float-right"><?php echo $debdet[7]; ?> Days</a>
                            </li>
                        </ul>

                       <?= Html::button('<i class="fa fa-edit"></i> Update Details', ['value'=>Url::to(['debtors/debtor-update','debid'=>$debid]),'title'=>'Update Debtor Info','class' => 'showModalButton btn btn-primary btn-block']) ?>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <h4><strong>Debtor History</strong></h4>
                    </div>
                    <div class="card-body">
                        <?php echo $debhist; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
<?php

$this->registerCssFile('@web/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');
//$this->registerCssFile('@web/plugins/datatables-responsive/css/responsive.bootstrap4.min.css');
//$this->registerCssFile('@web/plugins/datatables-buttons/css/buttons.bootstrap4.min.css');

$this->registerJsFile('@web/plugins/datatables/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-responsive/js/dataTables.responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-responsive/js/responsive.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/dataTables.buttons.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@web/plugins/jszip/jszip.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@web/plugins/pdfmake/pdfmake.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@web/plugins/pdfmake/vfs_fonts.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.html5.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.print.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.colVis.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<?php
$script = <<< JS
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    
    // get the click of the create button
    /*$('.loadPopup').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });*/
  });
JS;
$this->registerJs($script);
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-dialog',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
//        'clientOptions' => ['backdrop' => 'static', 'keyboard' => True]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<?php
$this->registerJsFile('@web/js/popup.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
