<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Company Info </h1>
            </div>
            <div class="col-sm-6" align="right">
                <?= Html::button('<i class="fa fa-edit"></i>Update Info', ['value'=>Url::to(['/users/upd-comp','compid'=>$compdet[0]]),'title'=>'Update Company Info','class'=>'showModalButton btn bg-olive']) ?>
            </div><!-- /.col -->
        </div>
    </div>
    <?php if (Yii::$app->session->hasFlash('success-createc')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('success-createc')?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('failed-createc')): ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('failed-createc')?>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 profile_detail">
                                <h2><i class="fas fa-building"></i> Company</h2>
                                <p><?php echo $compdet[1] ?><br>
                                Bank Name : <?php echo $compdet[9] ?> <br>
                                Account No : <?php echo $compdet[8] ?></p>
                            </div>
                            <div class="col-sm-5 profile_detail">
                                <h2><i class="fas fa-map-marker-alt"></i> Location</h2>
                                <p>Address : <?php echo $compdet[2] ?><br>
                                    Location : <?php echo $compdet[7] ?> </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 profile_detail">
                                <h2><i class="fas fa-user-alt"></i> Contact Person</h2>
                                <p>Contact Name : <?php echo $compdet[5] ?> <br>
                                   Phone No : <?php echo $compdet[6] ?> </p>
                            </div>
                            <div class="col-sm-5 profile_detail">
                                <h2><i class="fas fa-address-card"></i> Contact Info</h2>
                                <p>Email : <?php echo $compdet[4] ?><br>
                                   Telephone : <?php echo $compdet[3] ?></p>
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
    'size' => 'modal-lg',
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

