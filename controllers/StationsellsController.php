<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\Stationsells;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\APPRoles;

/**
 * StationsellsController implements the CRUD actions for Stationsells model.
 */
class StationsellsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Stationsells models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!APPRoles::isSupervisor()) {
            return $this->redirect(['users/noaccess']);
        }
        $userid = Yii::$app->user->id;
        $slist = Yii::$app->db->createCommand("select p.pump_id,p.pump_name,s.shell_name,s.location,o.oil_type,p.cur_litres as available_litres,
                    case when p.cur_staff_assigned = 0 then 'Not Assigned' else concat(t.first_name,' ',t.last_name) end Assigned,p.cur_staff_assigned
                    from pumps p 
                    inner join shells s on s.shell_id=p.station_id 
                    left join tbl_user t on t.id=p.cur_staff_assigned
                    inner join oil_type o on o.type_id=p.oil_type
                    where s.supervisor = '$userid'"
        )->queryAll(0);

        if (!empty($slist))
        {
            //add id='datatables' to make it data table
            $tbD = "<table id='example1' class='table table-striped table-condensed table-no-bordered table-hover' cellspacing='0' width='100%' style='width:100%'>";
            $tbD .= "<thead><tr><th>SN</th><th>Pump Name</th><th>Station Name</th><th>Location</th><th>Oil Type</th><th>Available Litres</th><th>Staff Assigned</th><th>Action</th></tr></thead><tbody>";
            $i = 1;

            foreach($slist as $ls)
            {
                $tbD .="<tr><td>$i</td><td>$ls[1]</td><td>$ls[2]</td><td>$ls[3]</td><td>$ls[4]</td><td>$ls[5]</td><td>$ls[6]</td>";
                $tbD .= "<td><b>" . Html::a('<i class="fa fa-eye" aria-hidden="true"></i> View Detail', ['stationsells/pumpdet', 'pumpid' => $ls[0], 'assigned'=> $ls[7]], ['class' => 'btn btn-info btn-sm']) . "</b></td></tr>";
                $i++;
            }
            $tbD .= "</tbody></table>";
        }else {

            $tbD = "<table class='table table-striped'><tr><td><font color='#b8860b'>No Shell Station Assigned.</font></td></tr> </table>";
        }


        return $this->render('index', [
            'tbD'=>$tbD ,
        ]);
    }

    public function actionPumpdet($pumpid,$assigned)
    {
        $model = new Stationsells();

        $lsale = $this->getlastsale($pumpid,$assigned);
        $dsale = $this->getdayhistory($pumpid);
        $isassigned = Yii::$app->db->createCommand("select count(*) from pumps where pump_id = :pumpid and cur_staff_assigned <> 0")->bindParam(':pumpid',$pumpid)->queryScalar();
        return $this->render('pump_detail', [
            'model'=>$model,'pumpid'=> $pumpid,'dsale'=>$dsale,
            'assigned'=>$assigned, 'lsale'=>$lsale,'isassigned'=>$isassigned
        ]);
    }

    public function getlastsale($pumpid,$assigned)
    {
        if($assigned == 0)
        {
            $r = "select p.pump_name,o.oil_type,case when p.cur_staff_assigned = 0 then 'Not Assigned' else concat(t.first_name,' ',t.last_name) end Assigned,p.cur_litres,
                CASE when  p.cur_staff_assigned=0 then 'No Shift' else date_format(s.shift_start,'%M %d %Y %h:%i:%s')  end shift_start,CASE when p.cur_staff_assigned=0 then ' ' when s.iscurrent='N' then ' ' else date_format(s.shift_end,'%M %d %Y %h:%i:%s') end shift_start
                from pumps p inner join oil_type o on o.type_id=p.oil_type left join tbl_user t on t.id=p.cur_staff_assigned left join station_sells s on s.pump_id=p.pump_id where p.pump_id = '$pumpid'";
        }else{
            $r = "select p.pump_name,o.oil_type,case when p.cur_staff_assigned = 0 then 'Not Assigned' else concat(t.first_name,' ',t.last_name) end Assigned,p.cur_litres,
                    CASE when s.shift_start is null then 'No Shift' else date_format(s.shift_start,'%M %d %Y %h:%i:%s') end shift_start,CASE when s.shift_end is null then ' ' else date_format(s.shift_end,'%M %d %Y %h:%i:%s')  end shift_start
                    from pumps p inner join oil_type o on o.type_id=p.oil_type inner join tbl_user t on t.id=p.cur_staff_assigned
                    inner join station_sells s on s.pump_id=p.pump_id where p.pump_id = '$pumpid' and s.iscurrent = 'Y'";
        }

        $cur_sale = Yii::$app->db->createCommand($r)->queryOne(0);

        $tbR = "<table class='table table-striped table-condensed' style='width: 70%'>";
        $tbR .= "<tr><th colspan='4' bgcolor='#F8F9F9' ><i class='fas fa-gas-pump'></i> Sale Details</th></tr>";
        $tbR .="<tr><th>Pump Name :</th><td style='padding-right: 10%'>$cur_sale[0]</td><th>Oil Type :</th><td>$cur_sale[1]</td></tr>";
        $tbR .="<tr><th>Staff Assigned :</th><td style='padding-right: 10%'>$cur_sale[2]</td><th>Available Litres :</th><td>$cur_sale[3]</td></tr>";
        $tbR .="<tr><th>Shift Start :</th><td style='padding-right: 10%'>$cur_sale[4]</td><th>Shift End :</th><td>$cur_sale[5]</td></tr>";
        $tbR .= "</table>";

        return $tbR;
    }

    public function getdayhistory($pumpid)
    {
        $r = "select  concat(t.first_name,' ',t.last_name) staff,date_format(s.shift_start,'%M %d %Y %h:%i:%s') shift_start,date_format(s.shift_end,'%M %d %Y %h:%i:%s') shift_end,s.opening_litres,s.closing_litres,litre_sold,s.total_sell,s.sell_id
              from station_sells s inner join tbl_user t on t.id=s.staff_id where pump_id = '$pumpid' and s.crdate = CURDATE() and s.iscurrent = 'N'";

        $all_sale = Yii::$app->db->createCommand($r)->queryAll(0);

        if (!empty($all_sale))
        {
            $tbD = "<table   class='table table-striped table-condensed table-no-bordered table-hover'>";
            $tbD .= "<tr><th colspan='9' bgcolor='#F8F9F9' >Today's Sales</th></tr>";
            $tbD .= "<tr><th>SN</th><th>Staff</th><th>Start</th><th>End</th><th>Initial Litres</th><th>Closing Litres</th><th>Total Litres</th><th>Total Amount</th><th>Action</th></tr>";
            $i = 1;

            foreach ($all_sale as $sale)
            {
                $tbD .= "<tr><td>$i</td><td>$sale[0]</td><td>$sale[1]</td><td>$sale[2]</td><td>$sale[3]</td><td>$sale[4]</td><td>$sale[5]</td><td>$sale[6]</td></tr>";
                //$tbD .= "<td><b>" . Html::a('<i class="glyphicon glyphicon-edit"></i> View Detail', ['stationsells/viewdet', 'sellid' => $sale[7]], ['class' => 'btn btn-info btn-sm']) . "</b></td></tr>";
                $i++;
            }
            $tbD .= "</table>";
        }else{
            $tbD = "<table class='table table-striped'><tr><td><font color='#b8860b'>No Sells Today.</font></td></tr> </table>";
        }

        return $tbD;
    }

    public function actionAssign($pumpid,$assigned)
    {
        $model = new Stationsells();
        $tit = Yii::$app->db->createCommand("select p.pump_name,s.shell_name from pumps p inner join shells s on s.shell_id=p.station_id where p.pump_id = '$pumpid'")->queryOne(0);
        $curst = Yii::$app->db->createCommand("select cur_staff_assigned from pumps p where p.pump_id = '$pumpid'")->queryScalar();

        $model->staff_id = $curst;

        if(isset($_POST['btnAssStaff']))
        {
            $model->load(\Yii::$app->request->post());
            $staff = $model->staff_id;
            $flag = 1;
            $crby = Yii::$app->user->id;
            $q = "CALL sp_assign_pump(:p_pumpid,:p_staff_id,:p_crby,:flag,@msg)";
            $cmd = Yii::$app->db->createCommand($q);
            $cmd->bindValue(':p_pumpid', $pumpid);
            $cmd->bindValue(':p_staff_id', $staff);
            $cmd->bindValue(':p_crby', $crby);
            $cmd->bindValue(':flag', $flag);
            //$cmd->bindParam(':msg', $message, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
            //$cmd->bindParam(':msg', $message, \PDO::PARAM_STR, 200);
            $cmd->execute();

            $message = Yii::$app->db->createCommand("select @msg as result;")->queryScalar();

            $r = explode(":", $message);
            if ($r[1] == 'success') {
                Yii::$app->session->setFlash('usuccess', $r[0]);
                return $this->redirect(['pumpdet','pumpid'=>$pumpid,'assigned'=>$assigned]);
            } else {
                Yii::$app->session->setFlash('ufailed', $r[0]);
                return $this->redirect(['pumpdet','pumpid'=>$pumpid,'assigned'=>$assigned]);
            }
        }
        return $this->renderAjax('assign_staff', [
            'model'=>$model,'pumpid'=> $pumpid,'assigned'=>$assigned,
            'tit'=>$tit, 'staffs'=>$this->getStaff(),
        ]);
    }

    public function actionReassign($pumpid,$assigned)
    {
        $model = new Stationsells();
        $tit = Yii::$app->db->createCommand("select p.pump_name,s.shell_name from pumps p inner join shells s on s.shell_id=p.station_id where p.pump_id = '$pumpid'")->queryOne(0);
        $curst = Yii::$app->db->createCommand("select cur_staff_assigned from pumps p where p.pump_id = '$pumpid'")->queryScalar();

        $model->staff_id = $curst;

        if(isset($_POST['btnReStaff']))
        {
            $model->load(\Yii::$app->request->post());
            $staff = $model->staff_id;
            $flag = 2;
            $crby = Yii::$app->user->id;
            $q = "CALL sp_assign_pump(:p_pumpid,:p_staff_id,:p_crby,:flag,@msg)";
            $cmd = Yii::$app->db->createCommand($q);
            $cmd->bindValue(':p_pumpid', $pumpid);
            $cmd->bindValue(':p_staff_id', $staff);
            $cmd->bindValue(':p_crby', $crby);
            $cmd->bindValue(':flag', $flag);
            //$cmd->bindParam(':msg', $message, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
            //$cmd->bindParam(':msg', $message, \PDO::PARAM_STR, 200);
            $cmd->execute();

            $message = Yii::$app->db->createCommand("select @msg as result;")->queryScalar();

            $r = explode(":", $message);
            if ($r[1] == 'success') {
                Yii::$app->session->setFlash('rsuccess', $r[0]);
                return $this->redirect(['pumpdet','pumpid'=>$pumpid,'assigned'=>$assigned]);
            } else {
                Yii::$app->session->setFlash('rfailed', $r[0]);
                return $this->redirect(['pumpdet','pumpid'=>$pumpid,'assigned'=>$assigned]);
            }
        }
        return $this->renderAjax('reassign_staff', [
            'model'=>$model,'pumpid'=> $pumpid,'assigned'=>$assigned,
            'tit'=>$tit, 'staffs'=>$this->getStaff(),
        ]);
    }

    public function actionEndshift($pumpid,$assigned)
    {
        $model = new Stationsells();
        $tit = Yii::$app->db->createCommand("select p.pump_name,s.shell_name from pumps p inner join shells s on s.shell_id=p.station_id where p.pump_id = '$pumpid'")->queryOne(0);
        $curst = Yii::$app->db->createCommand("select CONCAT(first_name, ' ', last_name) from tbl_user t inner join station_sells s on s.staff_id=t.id and pump_id = '$pumpid' and iscurrent = 'Y'")->queryScalar();

        $model->staff_name = $curst;

        $staff = Yii::$app->db->createCommand("select cur_staff_assigned from pumps where pump_id = '$pumpid'")->queryScalar();
       // if ($staff == 0) {

            //Yii::$app->session->setFlash('efsuccess', 'This Pump is not Assinged to any Staff.');
        //    return $this->redirect(['pumpdet','pumpid'=>$pumpid,'assigned'=>$assigned]);
       // }
        if(isset($_POST['btnEndShift']))
        {
            $model->load(\Yii::$app->request->post());
            $clitres = $model->closing_litres;
            $crby = Yii::$app->user->id;
            $q = "CALL sp_ending_shift(:p_staffid,:p_pumpid,:p_clitres,:p_crby,@msg)";
            $cmd = Yii::$app->db->createCommand($q);
            $cmd->bindValue(':p_staffid', $staff);
            $cmd->bindValue(':p_pumpid', $pumpid);
            $cmd->bindValue(':p_clitres', $clitres);
            $cmd->bindValue(':p_crby', $crby);
            //$cmd->bindValue(':flag', $flag);
            //$cmd->bindParam(':msg', $message, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
            //$cmd->bindParam(':msg', $message, \PDO::PARAM_STR, 200);
            $cmd->execute();

            $message = Yii::$app->db->createCommand("select @msg as result;")->queryScalar();

            $r = explode(":", $message);
            if ($r[1] == 'success') {
                Yii::$app->session->setFlash('esuccess', $r[0]);
            }
            $assigned = 0;
            return $this->redirect(['pumpdet','pumpid'=>$pumpid,'assigned'=>$assigned]);
        }
        return $this->renderAjax('end_shift',[
            'model'=>$model, 'pumpid'=> $pumpid,'assigned'=>$assigned,
            'tit'=>$tit,
        ]);
    }

    public function actionPumpsales($pumpid,$assigned)
    {
        $model = new Stationsells();

        $det = "select p.pump_id,p.pump_name,concat(t.first_name,' ',t.last_name) staff,o.oil_type,date_format(s.shift_start,'%M %d %Y %h:%i:%s') shift_start,
               date_format(s.shift_end,'%M %d %Y %h:%i:%s') shift_end,s.opening_litres,s.closing_litres,s.litre_sold,s.total_sell,s.sell_id,o.cur_price as price,s.staff_id
                from station_sells s inner join tbl_user t on t.id=s.staff_id inner join pumps p on p.pump_id=s.pump_id inner join oil_type o on o.type_id=p.oil_type where s.pump_id = '$pumpid' and s.iscurrent = 'N'";
        $Psale = Yii::$app->db->createCommand($det)->queryAll(0);

        $tbPsale ="<table id='example1' class='table table-striped table-bordered'>";
        $tbPsale .="<thead><tr><th>SN</th><th>Pump Name</th><th>Staff</th><th>Oil Type</th><th>Shift Start</th><th>Shift End</th><th>Litre Sold</th><th>Price</th><th>Total Sale</th><th>Action</th></tr></thead><tbody>";
        $i = 1;
        foreach ($Psale as $sale) {
            $tbPsale .="<tr><td>$i</td><td>$sale[1]</td><td>$sale[2]</td><td>$sale[3]</td><td>$sale[4]</td><td>$sale[5]</td><td>$sale[8]</td><td>$sale[11]</td><td>$sale[9]</td>";
            $tbPsale .= "<td><b>" . Html::a('View', ['stationsells/viewsale','sellid'=>$sale[10],'pumpid'=>$sale[0],'assigned'=>$sale[12]]) . "</b></td></tr>";
            $i++;
        }
        $tbPsale .="</tbody></table>";

        return $this->render('pump_sales', [
            'model'=>$model,'tbPsale'=>$tbPsale, 'pumpid'=> $pumpid,'assigned'=>$assigned,
        ]);
    }

    public function actionViewsale($sellid,$pumpid,$assigned)
    {
        $r="select l.shell_name,p.pump_name,concat(t.first_name,' ',t.last_name) staff,o.oil_type,date_format(s.shift_start,'%M %d %Y %h:%i:%s') shift_start,
            date_format(s.shift_end,'%M %d %Y %h:%i:%s') shift_end,s.opening_litres,s.closing_litres,litre_sold,s.total_sell,s.sell_id,o.cur_price
            from station_sells s 
            inner join tbl_user t on t.id=s.staff_id 
            inner join pumps p on p.pump_id=s.pump_id
            inner join shells l on l.shell_id=s.station_id
            inner join oil_type o on o.type_id=p.oil_type 
            where s.sell_id = '$sellid' and s.iscurrent = 'N'";

        $det = Yii::$app->db->createCommand($r)->queryOne(0);

        $tbR = "<table class='table table-striped table-condensed table-bordered' style='width: 100%'>";
        $tbR .= "<tr><th colspan='4' bgcolor='#00cae3' >Sale Details</th></tr>";
        $tbR .="<tr><th>Pump Name :</th><td style='padding-right: 10%'>$det[1]</td><th>Station Name :</th><td>$det[0]</td></tr>";
        $tbR .="<tr><th>Staff Name :</th><td style='padding-right: 10%'>$det[2]</td><th>Oil Price :</th><td>$det[11]</td></tr>";
        $tbR .="<tr><th>Shift Start :</th><td style='padding-right: 10%'>$det[4]</td><th>Shift End :</th><td>$det[5]</td></tr>";
        $tbR .="<tr><th>Opening Litres :</th><td style='padding-right: 10%'>$det[6]</td><th>ClosingLitres :</th><td>$det[7]</td></tr>";
        $tbR .="<tr><th>Litre Sold:</th><td style='padding-right: 10%'>$det[8]</td><th>Total Sale :</th><td>$det[9]</td></tr>";
        $tbR .= "</table>";

        return $this->render('view_sale',[
            'tbR'=>$tbR,'pumpid'=> $pumpid,'assigned'=>$assigned,
        ]);

    }

    public function actionReport()
    {
        return $this->render('report');
    }

    public function actionSsummary()
    {
        $model = new Stationsells();
        $gd = 0;
        $tbSsale = '';
        $dataProvider = '';

        if(isset($_POST['btngetGReport']))
        {
            $model->load(\Yii::$app->request->post());
            $sstart = $model->from_date;
            $send = $model->to_date;

            $tbSsale = $this->getGsummary($sstart,$send);

            return $this->render('ss_summary',[
                'model'=>$model,'stations' => $this->getStation(),
                'gd'=>$gd, 'tbSsale'=>$tbSsale,
            ]);
        }

        if(isset($_POST['btngetPReport']))
        {
            $model->load(\Yii::$app->request->post());
            $stationid = $model->station_id;
            $sstart = $model->date_from;
            $send = $model->date_to;
            $tbSsale=$this->getPumpsummary($stationid,$sstart,$send);

            return $this->render('ss_summary',[
                'model'=>$model,'stations' => $this->getStation(),
                'gd'=>$gd, 'tbSsale'=>$tbSsale,
            ]);
        }
        
        return $this->render('ss_summary',[
            'model'=>$model,'stations' => $this->getStation(),
            'gd'=>$gd,'tbSsale'=>$tbSsale,
        ]);
    }

    public function actionViewss($stationid,$sstart,$send)
    {
        $stname = Yii::$app->db->createCommand("select shell_name from shells where shell_id = '$stationid'")->queryScalar();

        $rs = "select p.pump_name,o.oil_type,sum(litre_sold) as Total_litres,sum(total_sell) Total_sell,s.station_id
                from station_sells s
                inner join pumps p on p.pump_id=s.pump_id
                inner join oil_type o on p.oil_type=o.type_id
                where s.crdate between STR_TO_DATE('$sstart', '%d/%m/%Y') and STR_TO_DATE('$send', '%d/%m/%Y')
                and s.station_id = '$stationid' and s.iscurrent = 'N'
                group by p.pump_name,o.oil_type";
        $ss = Yii::$app->db->createCommand($rs)->queryAll(0);

        $tbSview ="<table id='example1' class='table table-striped table-bordered'>";
        $tbSview .="<thead><tr><th>SN</th><th>Pump Name</th><th>Oil Type</th><th>Total Liters</th><th>Total Sales</th><th>Action</th></tr></thead><tbody>";
        $i = 1;
        foreach ($ss as $s)
        {
            $tbSview .="<tr><td>$i</td><td>$s[0]</td><td>$s[1]</td><td>$s[2]</td><td>$s[3]</td>";
            $tbSview .= "<td><b>" . Html::a('View', ['stationsells/viewspsummary','stationid'=>$s[4],'sstart'=>$sstart,'send'=>$send]) . "</b></td></tr>";
            $i++;
        }
        $tbSview .="</tbody></table>";

        return $this->render('ss_view',[
            'tbSview'=>$tbSview,'stname'=>$stname
        ]);
    }

    public function actionViewspsummary($stationid,$sstart,$send)
    {
        $stname = Yii::$app->db->createCommand("select shell_name from shells where shell_id = '$stationid'")->queryScalar();
        $tbVsummary = $this->getPumpsummary($stationid,$sstart,$send);
        return $this->render('viewspsummary',[
            'tbVsummary'=>$tbVsummary,'stationid'=>$stationid,
            'sstart'=>$sstart,'send'=>$send,'stname'=>$stname
        ]);
    }

    protected function getStaff()
    {
        $rg = Yii::$app->db->createCommand("select id,concat(first_name,' ',last_name) from tbl_user where groupid = 4")->queryAll(false);
        $OILArray = array();
        $OILArray[0] = 'Select Staff';
        foreach ($rg as $r) {
            $OILArray[$r[0]] = $r[1];
        }

        return $OILArray;
    }

    protected function getStation()
    {
        $range = Yii::$app->db->createCommand("select shell_id,shell_name from shells")->queryAll(false);
        $IDArray = array();
        $IDArray[0] = 'Select Station';
        foreach ($range as $rg) {
            $IDArray[$rg[0]] = $rg[1];
        }

        return $IDArray;
    }

    protected function getPump()
    {
        $range = Yii::$app->db->createCommand("select pump_id,pump_name from pumps")->queryAll(false);
        $PArray = array();
        $PArray[0] = 'Select Station';
        foreach ($range as $rg) {
            $PArray[$rg[0]] = $rg[1];
        }

        return $PArray;
    }

    protected function getGsummary($sstart,$send)
    {
        $rs = "select l.shell_name,sum(litre_sold) as Total_litres,sum(total_sell) Total_sell,s.station_id
                        from station_sells s
                        inner join  shells l on l.shell_id=s.station_id
                        where s.crdate between STR_TO_DATE('$sstart', '%d/%m/%Y') and STR_TO_DATE('$send', '%d/%m/%Y') and s.iscurrent = 'N'
                        group by l.shell_name";
        $ss = Yii::$app->db->createCommand($rs)->queryAll(0);

        $tbSsale ="<table id='example1' class='table table-striped table-bordered'>";
        $tbSsale .="<thead><tr><th>SN</th><th>Station Name</th><th>Total Liters</th><th>Total Sales</th><th>Action</th></tr></thead><tbody>";
        $i = 1;
        foreach ($ss as $s)
        {
            $tbSsale .="<tr><td>$i</td><td>$s[0]</td><td>$s[1]</td><td>$s[2]</td>";
            $tbSsale .= "<td><b>" . Html::a('View', ['stationsells/viewss','stationid'=>$s[3],'sstart'=>$sstart,'send'=>$send]) . "</b></td></tr>";
            $i++;
        }
        $tbSsale .="</tbody></table>";

        return $tbSsale;
    }

    protected function getPumpsummary($stationid,$sstart,$send)
    {
        $det = "select p.pump_id,p.pump_name,concat(t.first_name,' ',t.last_name) staff,o.oil_type,date_format(s.shift_start,'%M %d %Y %h:%i:%s') shift_start,
                date_format(s.shift_end,'%M %d %Y %h:%i:%s') shift_end,s.opening_litres,s.closing_litres,s.litre_sold,s.total_sell,s.sell_id,o.cur_price as price,s.staff_id
                from station_sells s 
                inner join tbl_user t on t.id=s.staff_id 
                inner join pumps p on p.pump_id=s.pump_id 
                inner join oil_type o on o.type_id=p.oil_type 
                where s.crdate between STR_TO_DATE('$sstart', '%d/%m/%Y') and STR_TO_DATE('$send', '%d/%m/%Y')
                and s.station_id = '$stationid' and s.iscurrent = 'N'";
        $Psale = Yii::$app->db->createCommand($det)->queryAll(0);

        $tbSsale ="<table id='example1' class='table table-striped table-bordered'>";
        $tbSsale .="<thead><tr><th colspan='10'>Station Sales</th></tr>";
        $tbSsale .="<tr><th>SN</th><th>Pump Name</th><th>Staff</th><th>Oil Type</th><th>Shift Start</th><th>Shift End</th><th>Litre Sold</th><th>Price</th><th>Total Sale</th></tr></thead><tbody>";
        $i = 1;
        foreach ($Psale as $sale) {
            $tbSsale .="<tr><td>$i</td><td>$sale[1]</td><td>$sale[2]</td><td>$sale[3]</td><td>$sale[4]</td><td>$sale[5]</td><td>$sale[8]</td><td>$sale[11]</td><td>$sale[9]</td>";
            //$tbSsale .= "<td><b>" . Html::a('View', ['stationsells/viewsale','sellid'=>$sale[10],'pumpid'=>$sale[0],'assigned'=>$sale[12]]) . "</b></td></tr>";
            $i++;
        }
        $tbSsale .="</tbody></table>";

        return $tbSsale;
    }

    public function actionList()
    {

        $id = $_POST['id'];

        $countRange = Yii::$app->db->createCommand("select count(*) from pump where station_id = '$id'")->queryScalar();

        $range = Yii::$app->db->createCommand("select pump_id,pump_name from pump where station_id = '$id'")->queryAll(0);

        if ($countRange > 0) {
            echo "<option value>Select Pump</option>";

            foreach ($range as $range) {
                echo "<option value='" . $range[0] . "'>" . $range[1] . "</option>";
            }
        } else {
            echo "<option>.</option>";
        }
    }

    public function actionVpsales()
    {
        $model = new Stationsells();
        $range = Yii::$app->db->createCommand("select pump_id,pump_name from pumps")->queryAll(false);
        return $this->render('vp_summary',[
            'model'=>$model,'stations'=>$this->getStation(),
            'pumps'=>$range
        ]);
    }

    /**
     * Displays a single Stationsells model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Stationsells model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stationsells();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sell_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Stationsells model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sell_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Stationsells model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stationsells model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stationsells the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stationsells::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
