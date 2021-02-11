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
                    <?= Html::a('<i class="fa fa-step-backward"></i> List of Bills', ['/debtors/bills'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('failed-makepay')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('failed-makepay')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('success-makepay')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('success-makepay')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('rev_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('rev_fail')?>
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
                                <p> &nbsp;&nbsp;<strong>Invoice No</strong>&nbsp;:&nbsp;&nbsp<?php echo $invid ?> <br/>
                                    <strong>Date Issued</strong> :&nbsp;&nbsp;<?php echo $invdet[1] ?> <br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Due Date</strong>&nbsp;:&nbsp;&nbsp;<?php echo $invend?> <br/>
                                </p>
                            </div>
                            <div class="col-lg-4" align="right">
                                <?php if($invdet[4] == 'C'){ ?>
                                    <?= Html::a('<i class="fa fa-print"></i> Print Invoice', ['/debtors/print-invoice', 'invid'=>$invid], ['class' => 'btn bg-yellow btn-sm'])?>
                                <?php }elseif($invdet[4] == 'I') { ?>
                                    <?= Html::a('<i class="fa fa-print"></i> Print Invoice (Partial Payment)', ['/debtors/print-invoice', 'invid'=>$invid], ['class' => 'btn btn-dark btn-sm'])?>
                                <?php }elseif($invdet[4] == 'P') { ?>
                                    <?= Html::a('<i class="fa fa-print"></i> Print Receipt', ['/debtors/print-receipt', 'invid'=>$invid], ['class' => 'btn bg-info btn-sm'])?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $dorderTB; ?>
                            </div>
                        </div>
                        <div class="col-md-4 offset-8">
                            <div class="row">
                                <div class="col-lg-6" align="right">
                                    <h6>Total Product :</h6>
                                    <h6>Total Cost :</h6>
                                    <h6>Amount Paid :</h6>
                                    <h6>Balance Due :</h6>
                                    <h6 class="btot">Total Payment :</h6>
                                </div>
                                <div class="col-lg-6">
                                    <h6><?php echo number_format($invdet[2]) ?></h6>
                                    <h6><?php echo number_format($invdet[3],2) ?></h6>
                                    <h6><?php echo number_format($invdet[5],2) ?></h6>
                                    <h6><?php echo number_format($invdet[6],2) ?></h6>
                                    <h6 class="btot"><?php echo number_format($invdet[5],2) ?></h6>
                                </div>
                            </div>
                            <?php if(app\models\APPRoles::ismakepayment($invid)){ ?>
                                <div class="row">
                                    <div  class="col-md-6" align='right'>
                                        <?= Html::button('<i class="fa fa-money-bill"></i> Make Payment', ['value'=>Url::to(['/debtors/billpayment', 'invid'=>$invid]),'title'=>'Bill Payment','class' => 'showModalButton btn btn-info btn-xs'])?>
                                    </div>
                                    <div  class="col-md-6">
                                        <?= Html::a('<i class="fa fa-fast-backward"></i> Reverse Order', ['/debtors/reverse-bill', 'invid'=>$invid], ['class' => 'btn btn-danger btn-xs','onClick' => 'return confirm("Are you sure you want to reverse this bill?")'])?>
                                    </div>
                                </div>
                            <?php } ?>
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
    'size' => 'modal-dialog',
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
