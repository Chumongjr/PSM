<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-fluid">
    <table style="width: 100%">
        <tr>
            <td align="left" style="width: 90%">
                <h1>Invoice</h1>
            </td>
            <td  class="invoice-ribbon" align="right">
                <p class="ribbon-inner">PENDING</p>
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 80%"><h4> <i class="fas fa-gas-pump"></i><b> <?php echo $compdet[1] ?>.</b></h4></td>
            <td><h4><small class="float-right">Date: <?php echo date('d-M-Y') ?></small></h4></td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 50px;">
        <tr style="padding-top: 100px">
            <td style="width: 40%">
                From
                <address>
                    <strong><?php echo $compdet[1] ?>.</strong><br>
                    <?php echo $compdet[2] ?><br>
                    <?php echo $compdet[7] ?><br>
                    Phone: <?php echo $compdet[3] ?><br>
                    Email: <?php echo $compdet[4] ?>
                </address>
            </td>
            <td style="width: 40%">
                To
                <address>
                    <strong><?php echo $debdet[0] ?></strong><br>
                    <?php echo $debdet[1] ?><br>
                    <?php echo $debdet[2] ?><br>
                    Phone :<?php echo $debdet[4] ?><br>
                    Email :<?php echo $debdet[3] ?>
                </address>
            </td>
            <td style="width: 40%">
                <b>Invoice # <?php echo $invid ?></b><br>
                <br>
                <b>Order ID:</b> <?php echo $invdet[0] ?><br>
                <b>Payment Due:</b> <?php echo $invend?><br>
                <b>Account:</b> <?php echo $compdet[8]?>
            </td>
        </tr>
    </table>
    <table id='example1' class='table table-striped table-condensed table-borderless' style="margin-top: 30px">
        <tr>
            <td>
                <?php echo $dorderTB; ?>
            </td>
        </tr>
    </table>
    <table class="table table-borderless" style="width: 100%">
        <tr>
            <td style="width: 50%">
                <table class="table table-borderless">
                    <tr>
                        <td>
                            <p class="lead">Payment Methods:</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                <tr>
                                    <td><b>Bank name:</b></td>
                                    <td><?php echo $compdet[9]?></td>
                                </tr>
                                <tr>
                                    <td><b>Acc name:</b></td>
                                    <td><?php echo $compdet[1]?></td>
                                </tr>
                                <tr>
                                    <td><b>Acc No:</b></td>
                                    <td><?php echo $compdet[8]?></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 70%">
                <table class="table table-borderless" style="margin-left: 50px">
                    <tr>
                        <td class="text-right">
                            <p class="lead">Amount Due <?php echo $invend?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                <tr>
                                    <td class="text-right"><b>Total Cost:</b></td>
                                    <td class="text-right">Tsh <?php echo number_format($invdet[4],2)?></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Payment Made:</b></td>
                                    <td class="text-right">Tsh <?php echo number_format($invdet[6],2)?></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>Balance Due:</b></td>
                                    <td class="text-right">Tsh <?php echo number_format($invdet[7],2)?></td>
                                </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 30%; margin-left: auto; margin-right: 0px;">
        <tr>
            <td align="center">
                <p>Authorized person</p>
                <p><?= Html::img(Url::to('@web/dist/img/Signature.jpg'), ['alt' => 'Signature']) ?></p>
                <h6>Emmanuel Kessy</h6>
                <p class="text-muted">Managing Director</p>
            </td>
        </tr>
    </table>
    <table style="width: 70%">
        <tr>
            <td>
                <h6>Terms &amp; Condition</h6>
                <p>This Remember to clear this invoice before the due Date.
                    Its a pleasure doing business with you, and thanks for being our Customer</p>
            </td>
        </tr>
    </table>

</div>