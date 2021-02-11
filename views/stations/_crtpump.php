<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reuser']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($model, 'pump_name')->textInput() ?>
                                <?= $form->field($model, 'initial_litres')->textInput() ?>

                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($model, 'oil_type')->dropDownList($otype) ?>
                                <?= $form->field($model, 'cur_litres')->textInput() ?>
                            </div>
                        </div>
                        <div class = "form-group">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary','name'=>'btnAddPump','id'=>'uptank' ]); ?>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

