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
                        <?php $form = kartik\form\ActiveForm::begin([ 'id' => 'signup-form',
                                'type' => ActiveForm::TYPE_VERTICAL,
                            ]); ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($model, 'ben_name')->textInput(['placeholder'=>'Enter Benefit Name']) ?>
                                <?= $form->field($model, 'is_percentage')->checkbox(['custom' => true,'id'=>'isper'])->label('Is Percentage') ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($model, 'fixed_amount')->textInput(['placeholder'=>'Enter Amount','id'=>'famt'])->label('Fixed Amount',['id'=>'lfamt']) ?>
                                <?= $form->field($model, 'percentage')->textInput(['placeholder'=>'00.00%','id'=>'per'])->label('Percentage',['id'=>'lper']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center">
                            <?php if($isupdt == true){ ?>
                                <?= Html::submitButton('Update', ['class'=> 'btn bg-olive','name'=>'btnUpdtben','id'=>'appleave']); ?>
                            <?php }else{ ?>
                                <?= Html::submitButton('Register', ['class'=> 'btn bg-olive','name'=>'btnRegben','id'=>'appleave']); ?>
                            <?php } ?>

                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$script = <<< JS
$(document).ready(function() {
     document.getElementById("per").value = 0;
     $("#per").prop("readonly", true);
    $('input[type="checkbox"]').click(function(){
        if($(this).is(":checked")){
            document.getElementById("famt").value = 0;
            $("#famt").prop("readonly", true);
            document.getElementById("per").value = "";
            $("#per").prop("readonly", false);
            console.log("Checkbox is checked.");
        }
        else if($(this).is(":not(:checked)")){
            document.getElementById("per").value = 0;
             $("#per").prop("readonly", true);
             document.getElementById("famt").value = "";
            $("#famt").prop("readonly", false);
            console.log("Checkbox is unchecked.");
        }
    });    
 });

JS;
$this->registerJs($script);
?>

