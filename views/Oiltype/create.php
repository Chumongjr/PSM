<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Oiltype */

$this->title = 'Create Oiltype';
$this->params['breadcrumbs'][] = ['label' => 'Oiltypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oiltype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
