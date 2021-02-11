<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oiltypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oiltype-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Oiltype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type_id',
            'oil_type',
            'cur_price',
            'crby',
            'crdate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
