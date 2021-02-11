<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Debtors */

$this->title = $model->debtor_id;
$this->params['breadcrumbs'][] = ['label' => 'Debtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="debtors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->debtor_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->debtor_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'debtor_id',
            'debtor_code',
            'debtor_name',
            'address',
            'tellephone',
            'Email:email',
            'contact_person',
            'phone_no',
            'invoice_period',
            'crby',
            'crdate',
        ],
    ]) ?>

</div>
