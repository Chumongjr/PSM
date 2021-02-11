<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OilInventory */

$this->title = 'Update Oil Inventory: ' . $model->inv_id;
$this->params['breadcrumbs'][] = ['label' => 'Oil Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inv_id, 'url' => ['view', 'id' => $model->inv_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oil-inventory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
