<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Debtorsales */

$this->title = 'Update Debtorsales: ' . $model->debtorsale_id;
$this->params['breadcrumbs'][] = ['label' => 'Debtorsales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->debtorsale_id, 'url' => ['view', 'id' => $model->debtorsale_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="debtorsales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
