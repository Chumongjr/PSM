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
                    <h1 class="m-0 text-dark"> User Profile </h1>
                </div><!-- /.col -->
                <div class="col-sm-6" align="right">
                    <?= Html::a('<i class="fa fa-step-backward"></i> List of Users', ['/users/index'], ['class'=>'btn bg-olive']) ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php if (Yii::$app->session->hasFlash('upd_success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('upd_success')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('upd_fail')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('upd_fail')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div  align="center">
                                            <?= Html::img(Url::to('@web/dist/img/user-img.jpg'), ['alt' => 'Signature','id'=>'profile-image1','class'=>'img-circle img-responsive']) ?>
                                            <input id="profile-image-upload" class="hidden" type="file">
                                            <div style="color:#999;" >click here to change profile image</div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4 style="color:#00b1b1;"><?php echo $userdet[0] ?> <?php echo $userdet[1] ?> </h4></span>
                                        <span><p><?php echo $userdet[5] ?></p></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr style="margin:5px 0 5px 0;">
                                <div class="row">
                                    <div class="col-sm-5 col-xs-6 title " ><b>First Name:</b></div><div class="col-sm-7 col-xs-6 "><?php echo $userdet[0] ?></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="bot-border"></div>
                                <div class="row">
                                    <div class="col-sm-5 col-xs-6 title " ><b>Last Name:</b></div><div class="col-sm-7 col-xs-6 "><?php echo $userdet[1] ?></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="bot-border"></div>
                                <div class="row">
                                    <div class="col-sm-5 col-xs-6 title " ><b>Email:</b></div><div class="col-sm-7 col-xs-6 "><?php echo $userdet[2] ?></div>
                                </div>
                                                <div class="clearfix"></div>
                                                <div class="bot-border"></div>
                                                <div class="row">
                                                    <div class="col-sm-5 col-xs-6 title " ><b>Username:</b></div><div class="col-sm-7 col-xs-6 "><?php echo $userdet[3] ?></div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="bot-border"></div>
                                                <div class="row">
                                                    <div class="col-sm-5 col-xs-6 title " ><b>Status</b></div><div class="col-sm-7 col-xs-6 "><?php echo $userdet[4] ?></div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="bot-border"></div>
                                                <div class="row">
                                                    <div class="col-sm-5 col-xs-6 title " >
                                                        <?= Html::button('<i class="fa fa-edit"></i> Update User', ['value'=>Url::to(['/users/update','id'=>$id]),'title'=>'Update User Info','class'=>'showModalButton btn bg-teal']) ?>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="bot-border"></div>
                                            </div>
                            <div class="col-lg-4">
                                <table class="table table-condensed">
                                    <tr><th colspan="3">Employee Details</th></tr>
                                    <tr><td>Basic Salary</td><td colspan="2"> 3,000,000/=</td></tr>
                                    <tr><td>Benefits </td><td> 1,000,000/=</td><td><?=Html::a('<i class="fa fa-print"></i> View Benefits', ['/debtors/print-receipt'], ['class' => 'btn bg-info btn-sm'])?></td></tr>
                                    <tr><td>Deductions </td><td> 500,000/=</td><td><?=Html::a('<i class="fa fa-print"></i> View Deductions', ['/debtors/print-receipt'], ['class' => 'btn bg-info btn-sm'])?></td></tr>
                                    <tr><td>Loans </td><td> 100,000/=</td><td><?=Html::a('<i class="fa fa-print"></i> View Loans', ['/debtors/print-receipt'], ['class' => 'btn bg-info btn-sm'])?></td></tr>
                                    <tr><td>Payee </td><td colspan="2"> 860,000/=</td></tr>
                                    <tr><td>Gross Pay </td><td colspan="2"> 4,000,000/=</td></tr>
                                    <tr style="background-color:#999;"><td >Net Pay </td><td colspan="2"> 2,540,000/=</td></tr>

                                </table>
                            </div>
                            <div class="col-lg-4">
                                <table class="table table-condensed">
                                    <tr><th>Current Month</th><th colspan="2"> March 2021</th></tr>
                                    <tr><th>Account No :</th><td colspan="2"> 0J2458762135</td></tr>
                                    <tr><th>Bank Name :</th><td colspan="2"> CRDB BANK,plc</td></tr>
                                    <tr><th>Get Salary Slip </th><td><?=Html::a('<i class="fa fa-print"></i> Print Slip', ['/debtors/print-receipt'], ['class' => 'btn bg-purple btn-sm'])?></td></tr>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$script = <<< JS
$(function() {
    $('#profile-image1').on('click', function() {
        $('#profile-image-upload').click();
    });
});
JS;
$this->registerJs($script);
?>
<?php
$this->registerCssFile('@web/css/invoice.css');
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
//        'clientOptions' => ['backdrop' => 'static', 'keyboard' => True]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<?php
$this->registerJsFile('@web/js/popup.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
