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
                            <div class="col-sm-5">
                                <?= $form->field($modelded, 'ded_name')->textInput(['placeholder'=>'Enter Deduction Name']) ?>
                                <?= $form->field($modelded, 'is_percentage')->checkbox(['custom' => true,'id'=>'isper'])->label('Is Percentage') ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($modelded, 'fixed_amount')->textInput(['placeholder'=>'Enter Amount','id'=>'famt'])->label('Fixed Amount',['id'=>'lfamt']) ?>
                                <?= $form->field($modelded, 'employee_perc')->textInput(['placeholder'=>'00.00%','id'=>'per1'])->label('Employee Percentage',['id'=>'lper1']) ?>
                                <?= $form->field($modelded, 'employer_perc')->textInput(['placeholder'=>'00.00%','id'=>'per2'])->label('Employer Percentage',['id'=>'lper2']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center" >
                            <?php if($isupdt == true){ ?>
                                <?= Html::submitButton('Update', ['class'=> 'btn bg-olive','name'=>'btnUpdtded','id'=>'appleave']); ?>
                            <?php }else{ ?>
                                <?= Html::submitButton('Register', ['class'=> 'btn bg-olive','name'=>'btnRegded','id'=>'appleave']); ?>
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
     document.getElementById("per1").value = 0;
     document.getElementById("per2").value = 0;
     $("#per1").prop("readonly", true);
      $("#per2").prop("readonly", true);
      
    $('input[type="checkbox"]').click(function(){
        if($(this).is(":checked")){
            document.getElementById("famt").value = 0;
            $("#famt").prop("readonly", true);
            document.getElementById("per1").value = "";
            $("#per1").prop("readonly", false);
            document.getElementById("per2").value = "";
            $("#per2").prop("readonly", false);
            console.log("Checkbox is checked.");
        }
        else if($(this).is(":not(:checked)")){
            document.getElementById("per1").value = 0;
             $("#per1").prop("readonly", true);
             document.getElementById("per2").value = 0;
             $("#per2").prop("readonly", true);
             document.getElementById("famt").value = "";
            $("#famt").prop("readonly", false);
            console.log("Checkbox is unchecked.");
        }
    });    
 });

JS;
$this->registerJs($script);
?>

