<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Benefits */

$this->title = 'Update Benefits: ' . $model->benid;
$this->params['breadcrumbs'][] = ['label' => 'Benefits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->benid, 'url' => ['view', 'id' => $model->benid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="benefits-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
