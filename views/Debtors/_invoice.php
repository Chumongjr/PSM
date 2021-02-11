<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Invoice</h1>
            </div>
            <div class="col-sm-6">
                <div class="invoice-ribbon"><div class="ribbon-inner">PAID</div></div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-gas-pump"></i><b> <?php echo $compdet[1] ?>.</b>
                                <small class="float-right">Date: <?php echo date('d-M-Y') ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong><?php echo $compdet[1] ?>.</strong><br>
                                <?php echo $compdet[2] ?><br>
                                <?php echo $compdet[7] ?><br>
                                Phone: <?php echo $compdet[3] ?><br>
                                Email: <?php echo $compdet[4] ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong><?php echo $debdet[0] ?></strong><br>
                                <?php echo $debdet[1] ?><br>
                                <?php echo $debdet[2] ?><br>
                                Phone :<?php echo $debdet[4] ?><br>
                                Email :<?php echo $debdet[3] ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice # <?php echo $invid ?></b><br>
                            <br>
                            <b>Order ID:</b> <?php echo $invdet[0] ?><br>
                            <b>Payment Due:</b> <?php echo $invend?><br>
                            <b>Account:</b> 968-34567
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <?php echo $dorderTB ?>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6">
                            <p class="lead">Payment Methods:</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <tr>
                                            <td><b>Bank name:</b></td>
                                            <td class="text-right">CRDB, Tanzania</td>
                                        </tr>
                                        <tr>
                                            <td><b>Acc name:</b></td>
                                            <td class="text-right">Emmanuel Kessy</td>
                                        </tr>
                                        <tr>
                                            <td><b>Acc No:</b></td>
                                            <td class="text-right">01J2335467895</td>
                                        </tr>
                                        <tr>
                                            <td><b>SWIFT code:</b></td>
                                            <td class="text-right">BTNPP34</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <p class="lead">Amount Due <?php echo $invend?></p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Total Cost:</th>
                                        <td>Tsh <?php echo number_format($invdet[4],2)?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Made</th>
                                        <td>Tsh <?php echo number_format($invdet[6],2)?></td>
                                    </tr>
                                    <tr>
                                        <th>Balance Due:</th>
                                        <td>Tsh <?php echo number_format($invdet[7],2)?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-center">
                                <p>Authorized person</p>
                                <?= Html::img(Url::to('@web/dist/img/Signature.jpg'), ['alt' => 'Signature']) ?>
                                <h6>Emmanuel Kessy</h6>
                                <p class="text-muted">Managing Director</p>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <h6>Terms &amp; Condition</h6>
                            <p>This Remember to clear this invoice before the due Date.
                                Its a pleasure doing business with you, and thanks for being our Customer</p>
                        </div>
                    </div>

                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?php
$this->registerCssFile('@web/css/invoice.css');
$this->registerJsFile('@web/js/popup.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

