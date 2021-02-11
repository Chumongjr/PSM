<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Create New Bill </h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('List of Debtors', ['/debtors/index'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('regdeb_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('reg_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('regdeb_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('reg_fail')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('scomplete_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('scomplete_fail')?>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <p class="billto"> Bill To</p>
                                <p> <?php echo $debdet[0] ?> <br/>
                                    <?php echo $debdet[1] ?> <br/>
                                    <?php echo $debdet[2] ?> <br/>
                                    <?php echo $debdet[3] ?> <br/>
                                    <?php echo $debdet[4] ?> <br/>
                                </p>
                            </div>
                            <div class="col-lg-4">
                                <p class="billinv"> </p>
                                <p> &nbsp;&nbsp;<strong>Invoice No</strong>&nbsp;:&nbsp;&nbsp<?php echo $debinv ?> <br/>
                                    <strong>Date Issued</strong> :&nbsp;&nbsp;<?php echo $ddate ?> <br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Due Date</strong>&nbsp;:&nbsp;&nbsp;<?php echo $invend?> <br/>
                                </p>
                            </div>
                        </div>
                        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'reuser']) ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <?= $form->field($model, 'station')->dropDownList($stations) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($model, 'oil_type')->dropDownList($otype) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($model, 'total_litre')->textInput(['placeholder'=>'Total Liters']) ?>
                            </div>
                        </div>
                        <div class = "form-group" align="left">
                            <?= Html::submitButton('Add', ['class'=> 'btn bg-olive','name'=>'btnAdd' ]); ?>
                        </div>
                        <?php \yii\bootstrap4\ActiveForm::end(); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $dorderTB; ?>
                            </div>
                        </div>
                        <div class="col-md-4 offset-8">
                            <div class="row">
                                <div class="col-lg-6" align="right">
                                    <h5>Total Product :</h5>
                                    <h5>Total Cost :</h5>
                                </div>
                                <div class="col-lg-6">
                                    <h5><?php echo number_format($invtotal[0]) ?></h5>
                                    <h5><?php echo number_format($invtotal[1],2) ?></h5>
                                </div>
                            </div>
                            <div  class="col-md-4 offset-4" align='right'>
                                <?= Html::a('Complete Order', ['/debtors/transfercomplete', 'debid'=>$debid,'debinv'=>$debinv], ['class' => 'btn btn-info btn-xs'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-sm',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
//        'clientOptions' => ['backdrop' => 'static', 'keyboard' => True]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<?php
$this->registerCssFile('@web/css/mystyle.css');
$this->registerJsFile('@web/js/popup.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
