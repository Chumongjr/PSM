<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Benefits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="benefits-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ben_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_percentage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'percentage')->textInput() ?>

    <?= $form->field($model, 'fixed_amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
