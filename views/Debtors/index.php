<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Debtors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debtors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Debtors', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'debtor_id',
            'debtor_code',
            'debtor_name',
            'address',
            'tellephone',
            //'Email:email',
            //'contact_person',
            //'phone_no',
            //'invoice_period',
            //'crby',
            //'crdate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
