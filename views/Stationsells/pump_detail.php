<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
    <section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark"> Station Pump Info </h1>
                </div><!-- /.col -->
                <div class="col-sm-8" align="right">
                    <?php if($isassigned > 0){ ?>
                        <?= Html::button('<i class="fa fa-tasks"></i> Re-Assign Staff',['value'=>url::to(['/stationsells/reassign','pumpid'=>$pumpid,'assigned'=>$assigned]),
                            'title'=> 'Reassign Pump',
                            'class' => 'showModalButton btn btn-sm btn-round btn-info',
                            'rel'=>"tooltip",
                            'data' => [
                                'placement' => 'bottom',
                                'original-title' => 'View Summary']
                        ])?>
                        <?= Html::button('<i class="fa fa-check-square" aria-hidden="true"></i> End Shift',['value'=>url::to(['/stationsells/endshift','pumpid'=>$pumpid,'assigned'=>$assigned]),
                            'title'=> 'End Shift',
                            'class' => 'showModalButton btn btn-sm btn-round btn-info',
                            'rel'=>"tooltip",
                            'data' => [
                                'placement' => 'bottom',
                                'original-title' => 'End Shift']
                        ])?>
                   <?php }else { ?>
                        <?= Html::button('<i class="fa fa-tasks"></i> Assign Staff',['value'=>url::to(['/stationsells/assign','pumpid'=>$pumpid,'assigned'=>$assigned]),
                            'title'=> 'Assign Staff',
                            'class' => 'showModalButton btn btn-sm btn-round btn-info',
                            'rel'=>"tooltip",
                            'data' => [
                                'placement' => 'bottom',
                                'original-title' => 'Assign Staff']
                        ]) ?>
                   <?php } ?>
                    <?= Html::a('<i class="fas fa-gas-pump"></i> Pump Sales Summary',url::to(['/stationsells/pumpsales','pumpid'=>$pumpid,'assigned'=>$assigned]),[
                        //'title'=> 'View',
                        'class' => 'btn btn-sm btn-round btn-info',
                        'rel'=>"tooltip",
                        'data' => [
                            'placement' => 'bottom',
                            'original-title' => 'View Summary']
                    ])?>
                    <?= Html::a('<i class="fa fa-list-ul" aria-hidden="true"></i> Station List', ['/stationsells/index'], ['class'=>'btn bg-olive btn-sm']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
        <?php if (Yii::$app->session->hasFlash('statreg_fail')): ?>
            <div class="alert alert-warning alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= Yii::$app->session->getFlash('statreg_fail')?>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('rfailed')): ?>
            <div class="alert alert-warning alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= Yii::$app->session->getFlash('rfailed')?>
            </div>
        <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('usuccess')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('usuccess')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('rsuccess')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('rsuccess')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('esuccess')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('esuccess')?>
        </div>
    <?php endif; ?>
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
                            <div class="col-md-12">
                                <?php echo $lsale; ?>
                            </div>
                            <hr />
                            <div class="col-md-12">
                                <?php echo $dsale; ?>
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