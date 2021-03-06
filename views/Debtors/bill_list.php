<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <?php if($bgroup == 'Pending'){ ?>
                        <h1 class="m-0 text-dark"> Unpaid Bill List </h1>
                    <?php }else if($bgroup =='Partial'){ ?>
                        <h1 class="m-0 text-dark"> Partial Paid Bills </h1>
                    <?php }else if($bgroup =='Paid'){ ?>
                        <h1 class="m-0 text-dark"> Paid Bills </h1>
                    <?php } ?>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?php if($bgroup == 'Pending'){ ?>
                        <?= Html::a('<i class = "fa fa-thumbs-up"></i> Paid Bills', ['/debtors/paid-bills'],['class'=>' btn bg-olive']) ?>
                    <?php }else if($bgroup =='Paid'){ ?>
                        <?= Html::a('Pending Payments', ['/debtors/bills'],['class'=>' btn bg-info']) ?>
                    <?php } ?>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('success-createdeb')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('success-createdeb')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('failed-createdeb')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('failed-createdeb')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('rev_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('rev_success')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo $tbBills ?>
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
