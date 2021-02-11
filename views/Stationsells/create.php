<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stationsells */

$this->title = 'Create Stationsells';
$this->params['breadcrumbs'][] = ['label' => 'Stationsells', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stationsells-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
