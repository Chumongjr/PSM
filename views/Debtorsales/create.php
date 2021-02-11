<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Debtorsales */

$this->title = 'Create Debtorsales';
$this->params['breadcrumbs'][] = ['label' => 'Debtorsales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debtorsales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
