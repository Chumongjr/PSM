<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OilInventory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oil-inventory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'station_id')->textInput() ?>

    <?= $form->field($model, 'tank_id')->textInput() ?>

    <?= $form->field($model, 'oil_type')->textInput() ?>

    <?= $form->field($model, 'total_litres')->textInput() ?>

    <?= $form->field($model, 'crby')->textInput() ?>

    <?= $form->field($model, 'crdate')->textInput() ?>

    <?= $form->field($model, 'edited_by')->textInput() ?>

    <?= $form->field($model, 'edited_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
