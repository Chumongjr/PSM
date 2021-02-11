<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-fluid">
    <div class="body-content">
        <div class="row" style="margin-top: 25px">
            <div class="col-lg-10">
                <h3 class="text-center"><u>Daily Sales Report for  <strong><?= $yesterday ?></strong></u></h3><br>
                <h4 class="text-center"><strong>Sales <?= $yesterday ?></strong></h4>
                <table class="display reportTable" id="reportTable" cellspacing="1" border="1" >
                    <thead>
                    <tr style="background-color: #f2f2f2">
                        <th>SN</th>
                        <th>Station Nae</th>
                        <th>Total Litres</th>
                        <th>Total Sale</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($daysales as $daysale):?>
                            <tr>
                                <td><?php $i ?></td>
                                <td><?= $daysale[0] ?></td>
                                <td><?= $daysale[0] ?></td>
                                <td><?= $daysale[0] ?></td>
                            </tr>
                        $i++;
                        <?php endforeach; ?>
                        <tr>
                            <td>Totals</td>
                            <td>Totals</td>
                            <td>Totals</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>