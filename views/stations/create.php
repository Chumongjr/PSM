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
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'restation']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($model, 'shell_name')->textInput() ?>
                                <?= $form->field($model, 'address')->textInput() ?>
                                <?= $form->field($model, 'supervisor')->dropDownList($sup) ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($model, 'location')->textInput() ?>
                                <?= $form->field($model, 'phone_no')->textInput() ?>
                                <?= $form->field($model, 'no_pumps')->textInput() ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center">
                            <?= Html::submitButton('Create', ['class'=> 'btn btn-primary','name'=>'btncrtstation','id'=>'uptank' ]); ?>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
