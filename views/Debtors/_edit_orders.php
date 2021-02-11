<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

?>
<section class="content">
    <div class="container-fluid">
        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 're']) ?>
        <div class="col-lg-12">
            <?= $form->field($model, 'total_litre')->textInput(['placeholder'=>'Total Liters'])->label(false) ?>
        </div>
        <div class = "form-group" align="center">
            <?= Html::submitButton('Update', ['class'=> 'btn bg-olive','name'=>'btndupdate' ]); ?>
        </div>
        <?php \yii\bootstrap4\ActiveForm::end(); ?>

    </div>
</section>
