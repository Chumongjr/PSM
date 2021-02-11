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
                    <h1 class="m-0 text-dark"><b><?php echo $stname?></b> Station Tanks Lists </h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('<i class="fa fa-step-backward"></i> Station List', ['/oilinventory/viewstations'], ['class'=>'btn bg-olive']) ?>
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
    <?php if (Yii::$app->session->hasFlash('t_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('t_fail')?>
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
                                    <?= $form->field($model, 'oil_type')->dropDownList($otype) ?>
                                    <?= $form->field($model, 'tank_capacity')->textInput() ?>
                                    <?= $form->field($model, 'available_litres')->textInput() ?>
                                </div>
                            </div>
                            <div class = "form-group">
                                <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary','name'=>'btnAddtank','id'=>'addtank' ]); ?>
                            </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        <hr />
                        <div class="col-lg-12">
                            <?php if(empty($stanks)){ ?>
                                <?php echo $tbTanks; ?>
                            <?php }else{ ?>
                                <table class="table">
                                    <thead>
                                        <tr><th colspan="6">Station Tanks Summary</th></tr>
                                        <tr><th style="width: 10px">SN</th><th>Oil Type</th><th>Tank Capacity</th><th>Available</th><th>Summary</th><th>Actions</th></tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($stanks as $tank) {?>
                                        <tr>
                                            <td><?php echo $i?></td><td><?php echo $tank[1] ?></td><td><?php echo $tank[3] ?></td><td><?php echo $tank[4] ?></td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar bg-olive" style="width: <?php echo $tank[5]?>%"></div>
                                                </div>
                                            </td>
                                            <td><b><?php echo Html::a('<i class="fa fa-edit"></i> Update', ['oilinventory/updtanks','tank'=>$tank[0],'station'=>$tank[6]], ['class' => 'btn btn-primary btn-xs']) ?></b</td>
                                        </tr>
                                        <?php $i++ ?>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
