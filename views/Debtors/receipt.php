<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-fluid">
    <table style="width: 100%">
        <tr>
            <td style="width: 50%;" >
                <table>
                    <tr>
                        <td style="margin-top: 0px;">
                            <address>
                                <h3><b><?php echo $compdet[1] ?></b></h3><br>
                                <?php echo $compdet[2] ?><br>
                                <?php echo $compdet[7] ?><br>
                                Phone: <?php echo $compdet[3] ?><br>
                                Email: <?php echo $compdet[4] ?><br>
                                <br>
                                <br>
                                <br>
                            </address>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%" align="right">
                <table>
                    <tr>
                        <td style="margin-left: 30px" >
                            <h3><b>RECEIPT</b></h3><br>
                            <p><img src="../web/dist/img/ltwa.png" alt="Avatar"></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 50px;">
        <tr style="padding-top: 100px">
            <td style="width: 40%">
                <p style="padding-bottom: 5px;">Bill To </p>
                <address >
                    <strong style="border-top: 2px solid dimgrey;"><?php echo $debdet[0] ?></strong><br>
                    <?php echo $debdet[1] ?><br>
                    <?php echo $debdet[2] ?><br>
                    Phone :<?php echo $debdet[4] ?><br>
                    Email :<?php echo $debdet[3] ?>
                </address>
            </td>
            <td style="width: 40%">
                <p style="padding-bottom: 5px;">Ship To </p>
                <address>
                    <strong style="border-top: 2px solid dimgrey; padding-top: 5px;"><?php echo $debdet[1] ?></strong><br>
                    <?php echo $debdet[2] ?><br>
                    Phone :<?php echo $debdet[4] ?><br>
                    Email :<?php echo $debdet[3] ?>
                </address>
                <br>
                <br>

            </td>
            <td style="width: 40%" align="center">
                <b>Receipt No: #<?php echo $invid ?></b><br>
                <br>
                <b>Payment Date:</b> <?php echo $invend?><br>
                <br><br>
                <br><br>
                <br>
                <br>
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
                            <p class="lead">Thank you for your Business</p>
                        </td>
                    </tr>

                </table>
            </td>
            <td style="width: 70%">
                <table class="table table-borderless" style="margin-left: 50px">
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
    <table style="width: 70%">
        <tr>
            <td>
                <h5><b>Notes &amp; Condition</b></h5>
                <p>This Payment was made in Cash.
                   Remember once payment has been made it's non REVERSABLE</p>
            </td>
        </tr>
    </table>

</div>

