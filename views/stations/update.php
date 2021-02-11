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
                    <h1 class="m-0 text-dark"><b>Station Name : </b><?php echo $stname ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('<i class="fa fa-step-backward"></i> Station List', ['/stations/index'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('crtp_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('crtp_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('crtp_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('crtp_fail')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('statupd_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('statupd_fail')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'updstation']) ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?= $form->field($model, 'shell_name')->textInput() ?>
                                        <?= $form->field($model, 'address')->textInput() ?>
                                        <?= $form->field($model, 'supervisor')->dropDownList($sup) ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?= $form->field($model, 'location')->textInput() ?>
                                        <?= $form->field($model, 'phone_no')->textInput() ?>
                                        <?= $form->field($model, 'no_pumps')->textInput() ?>
                                    </div>
                                </div>
                                <div class = "form-group" align="center">
                                    <?= Html::submitButton('Update', ['class'=> 'btn btn-primary','name'=>'btnupdstation','id'=>'upstation' ]); ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <?php echo $tbl;?>
                                </div>
                            </div>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        <hr />
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $pumps ?>
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