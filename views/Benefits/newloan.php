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
                        <?php $form = kartik\form\ActiveForm::begin([ 'id' => 'form-deduction',
                                'type' => ActiveForm::TYPE_VERTICAL,
                            ]); ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($modloan, 'loan_name')->textInput(['placeholder'=>'Enter Loan Name']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($modloan, 'payperiod')->textInput(['placeholder'=>'Enter Loan Repayment Period']) ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($modloan, 'interest')->textInput(['placeholder'=>'Enter Interest Percent','id'=>'lint'])->label('Interest Percent',['id'=>'lfamt']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center" >
                            <?php if($isupdt == true){ ?>
                                <?= Html::submitButton('Update', ['class'=> 'btn bg-olive','name'=>'btnUpdtloan','id'=>'appleave']); ?>
                            <?php }else{ ?>
                                <?= Html::submitButton('Register', ['class'=> 'btn bg-olive','name'=>'btnRegloan','id'=>'appleave']); ?>
                            <?php } ?>

                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

