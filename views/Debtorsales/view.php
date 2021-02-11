<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Debtorsales */

$this->title = $model->debtorsale_id;
$this->params['breadcrumbs'][] = ['label' => 'Debtorsales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="debtorsales-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->debtorsale_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->debtorsale_id], [
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
            'debtorsale_id',
            'debtor_id',
            'station_id',
            'total_litres',
            'total_sale',
            'status',
            'invoice_no',
            'crby',
            'crdate',
            'paid_amount',
            'payment_date',
            'payment_method',
            'captured_by',
        ],
    ]) ?>

</div>
