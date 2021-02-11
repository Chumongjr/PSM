<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Oiltype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oiltype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oil_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cur_price')->textInput() ?>

    <?= $form->field($model, 'crby')->textInput() ?>

    <?= $form->field($model, 'crdate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
