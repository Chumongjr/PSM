<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use \kartik\widgets\DatePicker;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Station Sales </h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('Back to Menu', ['/stationsells/report'], ['class'=>'btn bg-olive btn-sm']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <?php if (Yii::$app->session->hasFlash('ufailed')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('ufailed')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'assStaff']) ?>
                            <div class="row">
                                <div class="col-lg-12" align="left">
                                    <?= Html::button('<i class="right fas fa-angle-right"></i>General Sales Details',['class'=>'btn btn-primary','id'=>'detailed']) ?>
                                    <?= Html::button('<i class="right fas fa-angle-right"></i>Station Sales Report',['class'=>'btn btn-primary','id'=>'sdetails']) ?>
                                </div>
                            </div>
                            <hr />
                            <div class="row" id="gdet">
                                <div class="col-lg-5">
                                    <?= $form->field($model, 'from_date')->textInput(['placeholder'=>'dd/mm/yyyy']) ?>
                                </div>
                                <div class="col-lg-5">
                                    <?= $form->field($model, 'to_date')->textInput(['placeholder'=>'dd/mm/yyyy']) ?>
                                </div>
                            </div>
                            <div class="row" id="sdet">
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'station_id')->dropDownList($stations) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'date_from')->textInput(['placeholder'=>'dd/mm/yyyy']) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'date_to')->textInput(['placeholder'=>'dd/mm/yyyy']) ?>
                                </div>
                            </div>
                            <div class = "form-group" align="left">
                                <?= Html::submitButton('Get Report', ['class'=> 'btn btn-info','name'=>'btngetGReport','id'=>'greport' ]); ?>
                                <?= Html::submitButton('Get Report', ['class'=> 'btn btn-info','name'=>'btngetPReport','id'=>'preport' ]); ?>
                            </div>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="sresult">
                                <?php echo $tbSsale; ?>
                            </div>
                        </div>
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

$script = <<< JS
	$(document).ready(function() {
	    $("#gdet").hide();
	    $("#sdet").hide();
	    $("#greport").hide();
	    $("#preport").hide();
	    $("sresult").hide();
	    
        $("#detailed").click(function(){
            $("#gdet").show();
            $("#sdet").hide();
            $("#greport").show();
            $("#preport").hide();
            //e.preventDefault();
            //document.getElementById("#sdet").style.display = "none"; 
        });
        
        $("#sdetails").click(function(e){
            //alert("I am an alert box!");
            $("#gdet").hide();
            $("#sdet").show();
            $("#preport").show();
            $("#greport").hide();
            $("sresult").show();
            //document.getElementById("gdet").style.display = "none"; 
        });
        
        $("#greport").click(function(){
             $("#gdet").show();
             $("sresult").show();
            //e.preventDefault();
            //document.getElementById("#sdet").style.display = "none"; 
        });
        
        $("#preport").click(function(){
             $("sresult").show();
             $("#sdet").show();
            //e.preventDefault();
            //document.getElementById("#sdet").style.display = "none"; 
        });
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
    });
JS;
$this->registerJs($script);
?>
