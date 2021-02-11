<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pump Sales Report</h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('Add User', ['/users/create'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'vpsales']) ?>
                        <div class="row">
                           <div class="col-lg-5">
                               <?=  $form->field($model, 'station_id')->dropDownList($stations,
                                   [
                                       //'prompt'=>'Select Station',
                                       'onchange'=>'
                                          var n = $(this).val();
                                          console.log(n);
                                           $.post("list", {id : n}, function(data){
                                           console.log(data);
                                           $("select#spump").prop(\'disabled\', false);
                                           $("select#spump").html(data);
                                           });
                                           ','id'=>'stat'
                                   ]); ?>
                               <?= $form->field($model, 'date_from')->textInput(['placeholder'=>'dd/mm/yyyy']) ?>
                           </div>
                            <div class="col-lg-5">
                                <?=  $form->field($model, 'pump_id')->dropDownList(ArrayHelper::map($pumps,'pump_id','pump_name'),
                                    [
                                        'prompt'=>'Select Pump','id'=>'spump'
                                    ]); ?>
                                <?= $form->field($model, 'date_to')->textInput(['placeholder'=>'dd/mm/yyyy']) ?>
                            </div>


                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
