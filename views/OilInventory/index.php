<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oil Inventories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oil-inventory-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Oil Inventory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'inv_id',
            'station_id',
            'tank_id',
            'oil_type',
            'total_litres',
            //'crby',
            //'crdate',
            //'edited_by',
            //'edited_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
