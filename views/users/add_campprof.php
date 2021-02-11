<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Banks;

$banks = Yii::$app->db->createCommand("select bank_id,bank_name from banks")->queryAll(0);
$banklist = ArrayHelper::map($banks,'bank_id','bank_name');
?>
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Add Company Info </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reuser']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($modProfile, 'company_name')->textInput(['placeholder'=>'Company Name']) ?>
                                <?= $form->field($modProfile, 'email')->textInput(['placeholder'=>'info@info.com']) ?>
                                <?= $form->field($modProfile, 'contact_person')->textInput(['placeholder'=>'Enter Contact Personel']) ?>
                                <?= $form->field($modProfile, 'location')->textInput(['placeholder'=>'Enter Office Location']) ?>
                                <?= $form->field($modProfile, 'bank_name')->dropDownList($banklist,['prompt'=>'Select Bank Name']) ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($modProfile, 'address')->textInput(['placeholder'=>'P.O.Box XXXX']) ?>
                                <?= $form->field($modProfile, 'company_tel')->textInput(['placeholder'=>'0XX XXX XXXX']) ?>
                                <?= $form->field($modProfile, 'phone_no')->textInput(['placeholder'=>'+255 XXX XXX XXX']) ?>
                                <?= $form->field($modProfile, 'bank_acc')->textInput(['placeholder'=>'Enter Bank Acount']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center">
                            <?php if($has_profile > 0){ ?>
                                <?= Html::submitButton('Update', ['class'=> 'btn bg-olive','name'=>'btnUpdc','id'=>'appleave']); ?>
                            <?php }else{ ?>
                                <?= Html::submitButton('Register', ['class'=> 'btn bg-olive','name'=>'btnRegc','id'=>'appleave']); ?>
                            <?php } ?>

                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>