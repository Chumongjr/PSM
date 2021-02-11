<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-6">
                    <h1 class="m-0 text-dark"> Pump Lists </h1>
                </div><!-- /.col -->
                <div class="col-lg-6" align="right">
                    <?= Html::a('Add Pump', ['/stations/crtpump'], ['class'=>'btn bg-olive btn-sm']) ?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo $tbpumps; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
