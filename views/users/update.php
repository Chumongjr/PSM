<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'upduser']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($model, 'first_name')->textInput() ?>
                                <?= $form->field($model, 'email')->textInput() ?>
                                <?= $form->field($model, 'groupid')->dropDownList([1=>'Admin',2=>'Manager',3=>'Supervisor',4=>'Staffs']) ?>                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($model, 'last_name')->textInput() ?>
                                <?= $form->field($model, 'username')->textInput() ?>
                                <?= $form->field($model, 'status')->dropDownList(['A'=>'Activate','S'=>'Suspend']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center">
                            <?= Html::submitButton('Update', ['class'=> 'btn btn-primary','name'=>'btnUpdReguser','id'=>'upduser' ]); ?>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
