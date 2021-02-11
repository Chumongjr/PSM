<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

?>
<section class="content">
    <div class="container-fluid">
        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 're']) ?>
        <div class="col-lg-16">
            <?= $form->field($model, 'paid_amount')->textInput(['placeholder'=>'Amount Paid'])->label(true) ?>
            <?= $form->field($model, 'payment_type')->dropDownList(['P'=>'Partial Payment','F'=>'Full Payment'],['prompt'=>'Select Payment Type']) ?>
            <?= $form->field($model, 'payment_method')->dropDownList($pmethod) ?>
        </div>
        <div class = "form-group" align="center">
            <?= Html::submitButton('Submit', ['class'=> 'btn bg-olive','name'=>'btnmakepay' ]); ?>
        </div>
        <?php \yii\bootstrap4\ActiveForm::end(); ?>

    </div>
</section>
