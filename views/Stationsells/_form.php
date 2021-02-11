<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Stationsells */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stationsells-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'station_id')->textInput() ?>

    <?= $form->field($model, 'pump_id')->textInput() ?>

    <?= $form->field($model, 'staff_id')->textInput() ?>

    <?= $form->field($model, 'opening_litres')->textInput() ?>

    <?= $form->field($model, 'closing_litres')->textInput() ?>

    <?= $form->field($model, 'litre_sold')->textInput() ?>

    <?= $form->field($model, 'total_sell')->textInput() ?>

    <?= $form->field($model, 'shift_start')->textInput() ?>

    <?= $form->field($model, 'shift_end')->textInput() ?>

    <?= $form->field($model, 'crby')->textInput() ?>

    <?= $form->field($model, 'crdate')->textInput() ?>

    <?= $form->field($model, 'iscurrent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shift_ended_by')->textInput() ?>

    <?= $form->field($model, 'shift_ended_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
