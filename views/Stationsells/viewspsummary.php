<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
    <section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-8">
                    <h1 class="m-0 text-dark">Detailed Station Sales Summary:<?php echo $stname ?> </h1>
                </div><!-- /.col -->
                <div class="col-lg-4" align="right">
                    <?= Html::a('Back to Summary', ['/stationsells/viewss','stationid'=>$stationid,'sstart'=>$sstart,'send'=>$send], ['class'=>'btn bg-olive btn-sm']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo $tbVsummary ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
<?php

$this->registerCssFile('@web/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');
$this->registerCssFile('@web/plugins/datatables-responsive/css/responsive.bootstrap4.min.css');
$this->registerCssFile('@web/plugins/datatables-buttons/css/buttons.bootstrap4.min.css');



$this->registerJsFile('@web/plugins/datatables/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-responsive/js/dataTables.responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-responsive/js/responsive.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/dataTables.buttons.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.bootstrap4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/jszip/jszip.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/pdfmake/pdfmake.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/pdfmake/vfs_fonts.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.html5.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.print.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/plugins/datatables-buttons/js/buttons.colVis.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

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

