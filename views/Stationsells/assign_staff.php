<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'assStaff']) ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table style="background-color:#00bcd4; width: 100%;">
                                        <tr>
                                            <td style= "padding-right: 40px; padding-left: 20px;"><h4><font color="white"><b>Pump Name:</b> <?php echo $tit[0] ?> </font> </h4></td>
                                            <td style= "padding-right: 40px"><h4><font color="white"><b>Station Name:</b> <?php echo $tit[1] ?> </font> </h4></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-lg-10">
                                    <?= $form->field($model, 'staff_id')->dropDownList($staffs) ?>
                                </div>
                            </div>
                            <div class = "form-group">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= Html::submitButton('Assign', ['class'=> 'btn btn-info','name'=>'btnAssStaff','id'=>'uptank' ]); ?>
                            </div>
                            <?php \yii\bootstrap4\ActiveForm::end(); ?>
                            <hr />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
