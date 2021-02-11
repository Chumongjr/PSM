<?php
use yii\helpers\Html;
?>
<div class="card">
    <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

            <?= $form->field($model,'username', [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ])
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

            <div class="row">
                <div class="col-12" >
                    <?= Html::submitButton('Request new password', ['class' => 'btn btn-primary btn-block','name'=>'reqpass']) ?>
                </div>
            </div>

            <?php \yii\bootstrap4\ActiveForm::end(); ?>

            <p class="mb-1" align="center">
                <?= Html::a('Login',['/site/login']) ?>
            </p>
    </div>
    <!-- /.login-card-body -->
</div>