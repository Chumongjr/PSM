<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Oiltype */

$this->title = 'Update Oiltype: ' . $model->type_id;
$this->params['breadcrumbs'][] = ['label' => 'Oiltypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type_id, 'url' => ['view', 'id' => $model->type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oiltype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
