<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Reports </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <?= Html::a('<i class="right fas fa-angle-right"></i>Station Sales Summary', ['/stationsells/ssummary']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <?= Html::a('<i class="right fas fa-angle-right"></i>Pump Sales Report', ['/stationsells/vpsales']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <?= Html::a('<i class="right fas fa-angle-right"></i>Staff Shifts Report', ['/controller/action']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
