<?php
use yii\helpers\Html;

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'cprice','action' => ['oiltype/changeprice', 'id' => $id]]) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($modeln, 'cur_price')->textInput(['placeholder'=>'Enter New Price'])->label(false) ?>
                            </div>
                            <div class="col-sm-5" >
                                <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary','name'=>'btnPrice','id'=>'' ]); ?>
                            </div>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
