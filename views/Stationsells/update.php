<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stationsells */

$this->title = 'Update Stationsells: ' . $model->sell_id;
$this->params['breadcrumbs'][] = ['label' => 'Stationsells', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sell_id, 'url' => ['view', 'id' => $model->sell_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stationsells-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
