<?php
$this->title = 'Stroils';
$this->params['breadcrumbs'] = [['label' => $this->title]];
use yii\helpers\Url;
use yii\helpers\Html;
?>

<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-charging-station"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Stations</span>
                        <span class="info-box-number"><?php echo $stations ?>
                  <small></small>
                </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-gas-pump"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Pumps</span>
                        <span class="info-box-number"><?php echo $pumps ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Sales</span>
                        <span class="info-box-number"><?php echo number_format($sales,2) ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Debtors</span>
                        <span class="info-box-number"><?php echo $debtors ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Orders</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Debtor ID</th>
                                <th>Debtor Name</th>
                                <th>Invoice No.</th>
                                <th>Status</th>
                                <th>Litre</th>
                                <th>Total Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($orders as $order):?>
                                <tr>
                                    <td><?= Html::a($order[0],['debtors/debtordet','debid'=>$order[6]]) ?></td>
                                    <td><?php echo $order[1] ?></td>
                                    <td><?= Html::a($order[2],['debtors/invoice-bill','invid'=>$order[2]]) ?></td>
                                    <?php if($order[5] == 'C'){ ?>
                                        <td><span class='badge badge-warning'><?php echo $order[7] ?></span></td>
                                    <?php }else if($order[5] == 'I'){ ?>
                                        <td><span class='badge badge-secondary'><?php echo $order[7] ?></span></td>
                                    <?php }else{?>
                                         <td><span class='badge badge-success'><?php echo $order[7] ?></span></td>
                                    <?php } ?>
                                    <td><?php echo number_format($order[3]) ?></td>
                                    <td><?php echo number_format($order[4],2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <?= Html::a('Place New Order',['debtors/index'],['class'=>"btn btn-sm btn-info float-left"]) ?>
                    <?= Html::a('View All Orders',['debtors/bills'],['class'=>"btn btn-sm btn-secondary float-right"]) ?>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>