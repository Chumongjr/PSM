<?php
use app\models\APPRoles;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="../web/dist/img/STROILSLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><b>Stroils</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                        ['label' => 'Daily Sales', 'url' => ['stationsells/index'],'iconStyle' => 'far', 'iconClassAdded' => 'text-warning', 'visible' => APPRoles::isSupervisor()],
                   //['label' => 'Pumps', 'url' => ['stations/viewpumps'],'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                    [
                        'label' => 'Debtors Management',
                        'icon' => 'tachometer-alt',
                        //'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            //['label' => 'Oil Stock Management', 'url' => ['oilinventory/index'], 'iconStyle' => 'far'],
                            ['label' => 'Debtors', 'url' => ['debtors/index'],'iconStyle' => 'far', 'iconClassAdded' => 'text-success', 'visible' => APPRoles::isSupervisor()],
                            ['label' => 'Bill Payment', 'url' => ['debtors/bills'],'iconStyle' => 'far', 'iconClassAdded' => 'text-success', 'visible' => APPRoles::isSupervisor()],
                            ['label' => 'Payment Methods', 'url'=>['debtors/pay-methods'],'iconStyle' => 'far'],
                        ], 'visible' => APPRoles::isSupervisor()
                    ],
                    [
                        'label' => 'System Management',
                        'icon' => 'tachometer-alt',
                        //'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Company Profile', 'url' => ['users/comp-profile'], 'iconStyle' => 'far'],
                            ['label' => 'Stations', 'url' => ['stations/index'],'iconStyle' => 'far', 'iconClassAdded' => 'text-success', 'visible' => APPRoles::isManager()],
                            ['label' => 'Station Stocks', 'url'=>['oilinventory/viewstations'],'iconStyle' => 'far'],
                            ['label' => 'Oil Price','url'=>['oiltype/index'], 'iconStyle' => 'far'],
                        ], 'visible' => APPRoles::isManager()
                    ],
                    [
                        'label' => 'Payroll',
                        'icon' => 'tachometer-alt',
                        //'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Employee', 'url' => ['users/index'],'iconStyle' => 'far', 'iconClassAdded' => 'text-info', 'visible' => APPRoles::isManager()],
                            ['label' => 'HR Payroll', 'url' => ['stations/index'],'iconStyle' => 'far', 'iconClassAdded' => 'text-success', 'visible' => APPRoles::isManager()],
                            [
                                'label' => 'HR Maintainance',
                                'icon' => 'tachometer-alt',
                                //'badge' => '<span class="right badge badge-info">2</span>',
                                'items' => [
                                    ['label' => 'Position', 'url' => ['users/position'], 'iconStyle' => 'far'],
                                    ['label' => 'Benefits', 'url' => ['benefits/index'],'iconStyle' => 'far', 'iconClassAdded' => 'text-success', 'visible' => APPRoles::isManager()],
                                    ['label' => 'Deductions', 'url'=>['benefits/dedlist'],'iconStyle' => 'far'],
                                    ['label' => 'Loans','url'=>['benefits/loanlist'], 'iconStyle' => 'far'],
                                ],
                            ],
                        ], 'visible' => APPRoles::isManager()
                    ],
                    //['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'Reports', 'url' => ['stationsells/report'],'iconStyle' => 'far', 'iconClassAdded' => 'text-primary'],
                   // ['label' => 'Yii2 PROVIDED', 'header' => true],
                    //['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    //['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>