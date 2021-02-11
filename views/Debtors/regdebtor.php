<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reuser']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($model, 'debtor_code')->textInput() ?>
                                <?= $form->field($model, 'address')->textInput(['placeholder'=>'P.O.Box XXXX']) ?>
                                <?= $form->field($model, 'Email')->textInput(['placeholder'=>'info@info.com']) ?>
                                <?= $form->field($model, 'contact_person')->textInput(['placeholder'=>'Enter Contact Personel']) ?>


                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($model, 'debtor_name')->textInput(['placeholder'=>'Enter Company Name']) ?>
                                <?= $form->field($model, 'tellephone')->textInput(['placeholder'=>'0XX XXX XXXX']) ?>
                                <?= $form->field($model, 'invoice_period')->dropDownList([1=>7,2=>15,3=>30],['prompt'=>'Select Invoice Period']) ?>
                                <?= $form->field($model, 'phone_no')->textInput(['placeholder'=>'+255 XXX XXX XXX']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center">
                            <?php if($isupdt == true){ ?>
                                <?= Html::submitButton('Update', ['class'=> 'btn bg-olive','name'=>'btnUpdtdeb','id'=>'appleave']); ?>
                            <?php }else{ ?>
                                <?= Html::submitButton('Register', ['class'=> 'btn bg-olive','name'=>'btnRegdeb','id'=>'appleave']); ?>
                            <?php } ?>

                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
