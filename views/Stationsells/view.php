<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Stationsells */

$this->title = $model->sell_id;
$this->params['breadcrumbs'][] = ['label' => 'Stationsells', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stationsells-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sell_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sell_id], [
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
            'sell_id',
            'station_id',
            'pump_id',
            'staff_id',
            'opening_litres',
            'closing_litres',
            'litre_sold',
            'total_sell',
            'shift_start',
            'shift_end',
            'crby',
            'crdate',
            'iscurrent',
            'shift_ended_by',
            'shift_ended_at',
        ],
    ]) ?>

</div>
