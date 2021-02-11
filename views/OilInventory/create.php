<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OilInventory */

$this->title = 'Create Oil Inventory';
$this->params['breadcrumbs'][] = ['label' => 'Oil Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oil-inventory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
