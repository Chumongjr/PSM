<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Debtorsales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debtorsales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Debtorsales', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'debtorsale_id',
            'debtor_id',
            'station_id',
            'total_litres',
            'total_sale',
            //'status',
            //'invoice_no',
            //'crby',
            //'crdate',
            //'paid_amount',
            //'payment_date',
            //'payment_method',
            //'captured_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
