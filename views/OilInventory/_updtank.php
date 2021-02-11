<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-4">
                    <h4 class="m-0 text-dark"><b>Station Name : </b> <?php echo $summ[0] ?></h4>
                </div><!-- /.col -->
                <div class="col-lg-4">
                    <h4 class="m-0 text-dark"><b>Tank Type : </b><?php echo $summ[1] ?></h4>
                </div><!-- /.col -->
                <div class="col-lg-4" align="right">
                    <?= Html::a('<i class="fa fa-step-backward"></i> Tank List', ['/oilinventory/stdetails','stid'=>$station], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('t_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('t_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('upltr_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('upltr_fail')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reuser']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($modT, 'tank_capacity')->textInput(['readOnly'=>true]) ?>
                                <?= $form->field($model, 'avail_ltr')->textInput(['readOnly'=>true]) ?>
                                <?= $form->field($model, 'total_litres')->textInput() ?>
                            </div>
                        </div>
                        <div class = "form-group">
                            <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary','name'=>'btnUpdtank','id'=>'uptank' ]); ?>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        <hr />
                        <div class="col-lg-12">
                            <?php echo $tbInv;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
