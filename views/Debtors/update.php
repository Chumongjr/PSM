<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Debtors */

$this->title = 'Update Debtors: ' . $model->debtor_id;
$this->params['breadcrumbs'][] = ['label' => 'Debtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->debtor_id, 'url' => ['view', 'id' => $model->debtor_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="debtors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
