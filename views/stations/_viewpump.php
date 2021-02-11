<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-6">
                    <h2 class="m-0 text-dark"> Pump Name : <?php echo $pump_name ?></h2>
                </div><!-- /.col -->
                <div class="col-lg-6" align="right">
                    <?= Html::a('<i class="fa fa-step-backward"></i>Back to Station', ['/stations/stationdet','statid'=>$statid], ['class'=>'btn bg-olive btn-sm']) ?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('delp_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('delp_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('delp_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('delp_fail')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('updp_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('updp_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('updp_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('updp_fail')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <?php echo $tbP; ?>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <h5><b>Pump Sales Summary</b></h5>
                            <div class="col-sm-12">
                                <?= GridView::widget([
                                    'tableOptions' => [
                                        'class' => 'table table-striped table-no-bordered table-hover',
                                    ],
                                    'options'          => ['class' => 'table-responsive grid-view'],
                                    'dataProvider' => $dataProvider,
                                    'emptyText' => '<b><i>No Sales Found.</i></b>',
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'pump_name',
                                        'staff',
                                        //'oil_type',
                                        'shift_start',
                                        'shift_end',
                                        //'opening_litres',
                                        //'closing_litres',
                                        'litre_sold',
                                        'price',
                                        'total_sell',
                                        //'date_updated',
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
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
