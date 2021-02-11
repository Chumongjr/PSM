<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Create New User </h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('Back', ['/users/index'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('reg_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('reg_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('reg_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('reg_fail')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reuser']) ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($model, 'first_name')->textInput() ?>
                                <?= $form->field($model, 'email')->textInput() ?>
                                <?= $form->field($model, 'passwd')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($model, 'last_name')->textInput() ?>
                                <?= $form->field($model, 'username')->textInput() ?>
                                <?= $form->field($model, 'groupid')->dropDownList([1=>'Admin',2=>'Manager',3=>'Supervisor',4=>'Staffs']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="center">
                            <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary','name'=>'btnReguser','id'=>'appleave' ]); ?>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
