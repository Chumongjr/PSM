<?php

use app\models\Oiltype;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Oils Type </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-10">
                            <?php Pjax::begin(); echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'emptyText' => '<b><i>No Result Found.</i></b>',
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'oil_type',
                                    'price',
                                    [
                                        'class' => 'kartik\grid\ExpandRowColumn',
                                        'width' => '50px',
                                        'value' => function ($model_app, $key, $index, $column) {
                                            return GridView::ROW_COLLAPSED;
                                        },
                                        // uncomment below and comment detail if you need to render via ajax
                                        // 'detailUrl' => Url::to(['/pensioner/colpsrow','id'=>$model_app['CHANGE_ID']]),
                                        'detail' => function ($model, $key, $index, $column) {

                                            $modeln = new Oiltype();
                                            $id = $model['type_id'];

                                            return Yii::$app->controller->renderPartial('_colpsrow', ['modeln'=>$modeln,'id'=>$id]);
                                        },
                                         'headerOptions' => ['class' => 'kartik-sheet-style'] ,
                                         'expandOneOnly' => true,

                                    ],
                                ],
                                'responsive' => true,
                                'hover' => true,
                                'condensed' => true,
                            ]); Pjax::end();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>