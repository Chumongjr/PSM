<?php

namespace app\controllers;

use app\models\Pumps;
use Yii;
use app\models\Stations;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * StationsController implements the CRUD actions for Stations model.
 */
class StationsController extends Controller
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
     * Lists all Stations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Stations();

        $ry = "select s.shell_id,s.shell_name,s.location,s.phone_no,CONCAT(t.first_name, ' ', t.last_name) supervisor, s.no_pumps
               from shells s inner join tbl_user t on s.supervisor=t.id";
        $rs = Yii::$app->db->createCommand($ry)->queryAll(0);

        $tbstations = "<table id='example1' class='table table-hover text-nowrap'>";
        $tbstations .="<thead><tr><th>SN</th><th>Station Name</th><th>Location</th><th>Phone No.</th><th>Supervisor</th><th>No. Pumps</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($rs as $s)
        {
            $tbstations .= "<tr><td>$i</td><td>$s[1]</td><td>$s[2]</td><td>$s[3]</td><td>$s[4]</td><td>$s[5]</td>";
            $tbstations .= "<td><b>" . Html::a('<i class="fa fa-eye"></i> View Detail', ['stations/stationdet','statid'=>$s[0]], ['class' => 'btn btn-primary btn-xs']) . "</b></td></tr>";
            $i++;
        }
        $tbstations .="</tbody></table>";

        return $this->render('station_list', [
            'model' => $model,'tbStation'=>$tbstations
        ]);
    }

    /**
     * Displays a single Stations model.
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
     * Creates a new Stations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stations();

        if(isset($_POST['btncrtstation']))
        {
            $model->load(Yii::$app->request->post());
            $crby = Yii::$app->user->id;
            $shellname = $model->shell_name;
            $location = $model->location;
            $addr = $model->address;
            $phone = $model->phone_no;
            $sup = $model->supervisor;
            $pumps = $model->no_pumps;
            $crdate = date('Y-m-d');

            $q = "insert into shells(shell_name,location,address,phone_no,supervisor,no_pumps,crby,crdate)values (:shell,:location,:addrs,:phone,:sup,:pumps,:crby,:crdate)";
            $r = \Yii::$app->db->createCommand($q);
            $r->bindParam(":shell",$shellname);
            $r->bindParam(":location",$location);
            $r->bindParam(":addrs",$addr);
            $r->bindParam(":phone",$phone);
            $r->bindParam(":sup",$sup);
            $r->bindParam(":pumps",$pumps);
            $r->bindParam(":crby",$crby);
            $r->bindParam(":crdate",$crdate);
            $r->execute();

            if($r)
            {
                \Yii::$app->session->setFlash('statreg_success','Station Create Successfully');
                return $this->redirect(['index']);
            }  else{
                \Yii::$app->session->setFlash('statreg_fail','Failed,Please contact Administrator');
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('create', [
            'sup' =>$this->getSupervisor(),
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Stations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionStationdet($statid)
    {
        $model = new Stations();
        $stname = Yii::$app->db->createCommand("select shell_name from shells where shell_id = '$statid'")->queryScalar();

        $rst = Yii::$app->db->createCommand("select shell_name, location, address,phone_no,supervisor,no_pumps from shells where shell_id = '$statid'")->queryOne(0);
        $model->shell_name = $rst[0];
        $model->location = $rst[1];
        $model->address = $rst[2];
        $model->phone_no = $rst[3];
        $model->supervisor = $rst[4];
        $model->no_pumps = $rst[5];

        if (isset($_POST['btnupdstation']))
        {
            $model->load(Yii::$app->request->post());
            $upby = Yii::$app->user->id;
            $shell = $model->shell_name;
            $loc = $model->location;
            $add = $model->address;
            $nomber = $model->phone_no;
            $supervisor = $model->supervisor;
            $pumpno = $model->no_pumps;
            $update = date('Y-m-d');

            $q = "update shells set shell_name = '$shell',location='$loc',address='$add',phone_no='$nomber',supervisor='$supervisor',no_pumps='$pumpno',updated_by='$upby',date_updated='$update' where shell_id = '$statid'";
            $shupdate = \Yii::$app->db->createCommand($q)->execute();

            return $this->redirect([$this->actionStationdet($statid)]);
        }

        return $this->render('update', [
            'model' => $model, 'sup' => $this->getSupervisor(),
            'stname'=>$stname,'tbl'=>$this->getstatsummary($statid),
            'pumps'=> $this->getpumps($statid),'statid'=>$statid,
        ]);
    }

    protected function getSupervisor()
    {
        $range = Yii::$app->db->createCommand("select id,CONCAT(first_name, ' ', last_name) staff_name from tbl_user where groupid = 3")->queryAll(false);
        $IDArray = array();
        $IDArray[0] = 'Select Shell Supervisor';
        foreach ($range as $rg) {
            $IDArray[$rg[0]] = $rg[1];
        }

        return $IDArray;
    }

    private function getstatsummary($statid)
    {
        $er = "select s.shell_name,s.location,s.address,s.phone_no,s.no_pumps,CONCAT(t.first_name, ' ', t.last_name) supervisor
                from shells s inner join tbl_user t on t.id=s.supervisor where shell_id = '$statid'";
        $sm =Yii::$app->db->createCommand($er)->queryOne(0);

        $tbSummary = "<table class='table table-condensed'>";
        $tbSummary .="<tr><th colspan='2' style='background-color: #d3d3d3'><b>Station Details</b></th></tr>";
        $tbSummary .="<tr><th align='right'>Station Name :</th><td>$sm[0]</td></tr>";
        $tbSummary .="<tr><th align='right'>Location :</th><td>$sm[1]</td></tr>";
        $tbSummary .="<tr><th align='right'>Address :</th><td>$sm[2]</td></tr>";
        $tbSummary .="<tr><th align='right'>Phone No. :</th><td>$sm[3]</td></tr>";
        $tbSummary .="<tr><th align='right'>No. Pump :</th><td>$sm[4]</td></tr>";
        $tbSummary .="<tr><th align='right'>Supervisor :</th><td>$sm[5]</td></tr>";
        $tbSummary .="</table>";

        return $tbSummary;
    }

    private function getpumps($statid)
    {
        $pms = Yii::$app->db->createCommand("select p.pump_id,p.pump_name,o.oil_type,p.cur_litres from pumps p inner join oil_type o on o.type_id=p.oil_type where p.station_id = '$statid'")->queryAll(0);

        $tbpms = "<table class='table table-condensed'>";
        $tbpms .= "<tr><th colspan='2'> Station Pumps</th><td colspan='3' align='right'><b>" . Html::button('<i class="fa fa-plus"></i> Add Pump', ['value'=>Url::to(['stations/crtpump','statid'=>$statid]), 'title'=>'Add New Pump','class'=>'showModalButton btn btn-sm bg-olive']) . "</b></tr>";
        $tbpms .="<tr><th>SN</th><th>Pump Name</th><th>Oil Type</th><th>Cur Litre</th><th>Action</th></tr>";
        if(!empty($pms))
        {
            $i=1;
            foreach ($pms as $pm)
            {
                $tbpms .= "<tr><td>$i</td><td>$pm[1]</td><td>$pm[2]</td><td>$pm[3]</td>";
                $tbpms .= "<td><b>" . Html::a('<i class="fa fa-eye"></i> Details', ['stations/pumpdet','pumpid'=>$pm[0]], ['class' => 'btn btn-primary btn-xs']) . "</b></td></tr>";
                $i++;
            }
        }else{
            $tbpms .= "<tr><td>No Pump added. Please Add.</td></tr>";
        }

        $tbpms .="</table>";

        return $tbpms;
    }

    public function actionViewpumps()
    {
        $d = "select p.pump_id,p.pump_name,s.shell_name,o.oil_type,p.initial_litres,p.cur_litres as available_litres from pumps p inner join shells s on s.shell_id=p.station_id left join oil_type o on o.type_id=p.oil_type";
        $dets = Yii::$app->db->createCommand($d)->queryAll(0);

        $tbpumps = "<table class='table table-condensed'>";
        $tbpumps .="<tr><th>SN</th><th>Pump Name</th><th>Station Name</th><th>Oil Type</th><th>Initial Litres</th><th>Cur Litre</th><th>Action</th></tr>";

        if(!empty($dets))
        {
            $i=1;
            foreach ($dets as $det)
            {
                $tbpumps .= "<tr><td>$i</td><td>$det[1]</td><td>$det[2]</td><td>$det[3]</td><td>$det[4]</td><td>$det[5]</td>";
                $tbpumps .= "<td><b>" . Html::a('<i class="icon edit"></i>Details', ['stations/pumpdet','pumpid'=>$det[0]], ['class' => 'btn btn-primary btn-xs']) . "</b></td></tr>";
                $i++;
            }
        }else{
            $tbpumps .= "<tr><td>No Pump added. Please Add.</td></tr>";
        }
        $tbpumps .="</table>";

        return $this->render('_pumps',[
            'tbpumps'=>$tbpumps,
        ]);
    }

    public function actionPumpdet($pumpid)
    {
        $model = new Pumps();
        $pump_name = Yii::$app->db->createCommand("select pump_name from pumps where pump_id='$pumpid'")->queryScalar();
        $det = "select p.pump_id,p.pump_name,concat(t.first_name,' ',t.last_name) staff,o.oil_type,date_format(s.shift_start,'%M %d %Y %h:%i:%s') shift_start,
               date_format(s.shift_end,'%M %d %Y %h:%i:%s') shift_end,s.opening_litres,s.closing_litres,s.litre_sold,s.total_sell,s.sell_id,o.cur_price as price,s.staff_id
                from station_sells s inner join tbl_user t on t.id=s.staff_id inner join pumps p on p.pump_id=s.pump_id inner join oil_type o on o.type_id=p.oil_type where s.pump_id = '$pumpid' and s.iscurrent = 'N' order by s.crdate desc ";

        $dataProvider = new SqlDataProvider([
            'sql' => $det,
            'key' => 'sell_id',
            'pagination' => [ 'pageSize' => 10 ],
        ]);
        $stid = Yii::$app->db->createCommand("select station_id from pumps where pump_id='$pumpid'")->queryScalar();
        return $this->render('_viewpump',[
            'tbP'=>$this->getPumpdet($pumpid),'dataProvider'=>$dataProvider,
            'pump_name'=>$pump_name,'statid'=>$stid,
        ]);
    }

    public function actionCrtpump($statid)
    {
        $model = new Pumps();

        //$stid = Yii::$app->db->createCommand("select station_id from pumps where pump_id='$pumpid'")->queryScalar();
        if(isset($_POST['btnAddPump']))
        {
            $model->load(\Yii::$app->request->post());

            $crby = Yii::$app->user->id;
            $crdate = date('Y-m-d');
            $pname = $model->pump_name;
            //$pstation = $model->station_id;
            $init = $model->initial_litres;
            $cur = $model->cur_litres;
            $oilt = $model->oil_type;

            $q = "insert into pumps(pump_name,station_id,initial_litres,cur_litres,crby,crdate,oil_type)values (:pname,:pstation,:init,:cur,:crby,:crdate,:oilt)";
            $r = \Yii::$app->db->createCommand($q);
            $r->bindParam(":pname",$pname);
            $r->bindParam(":pstation",$statid);
            $r->bindParam(":init",$init);
            $r->bindParam(":cur",$cur);
            $r->bindParam(":crby",$crby);
            $r->bindParam(":crdate",$crdate);
            $r->bindParam(":oilt",$oilt);
            $r->execute();

            if($r)
            {
                \Yii::$app->session->setFlash('crtp_success','Pump Created Successfully');
                return $this->redirect(['stations/stationdet','statid'=>$statid]);

            }  else{
                \Yii::$app->session->setFlash('crtp_fail','Failed,Please contact Administrator');
                return $this->redirect(['stations/stationdet','statid'=>$statid]);
                /*return $this->render('create', [
                    'action'=> 'create', 'stations' =>$this->getStation(),
                    'model' => $model, 'otype' => $this->getOils(),'statid'=>$statid,
                ]);*/
            }
        }

        return $this->renderAjax('_crtpump', [
            'action'=> 'create', 'stations' =>$this->getStation(),
            'model' => $model,'otype' => $this->getOils(),'statid'=>$statid
        ]);
    }

    public function actionUpdpump($pumpid)
    {
        $model = new Pumps();

        $station_id = Yii::$app->db->createCommand("select station_id from pumps where pump_id='$pumpid'")->queryScalar();

        $rst = Yii::$app->db->createCommand("select pump_name,station_id,initial_litres,cur_litres,oil_type from pumps where pump_id = '$pumpid'")->queryOne(0);
        $model->pump_name = $rst[0];
        $model->station_id = $rst[1];
        $model->initial_litres = $rst[2];
        $model->cur_litres = $rst[3];
        $model->oil_type = $rst[4];

        if(isset($_POST['btnupdPump']))
        {
            $model->load(Yii::$app->request->post());
            $upby = Yii::$app->user->id;
            $pumpname = $model->pump_name;
            //$station_id = $model->station_id;
            $initial = $model->initial_litres;
            $current = $model->cur_litres;
            $oil = $model->oil_type;
            $update = date('Y-m-d');

            $q = "update pumps set pump_name = '$pumpname',station_id='$station_id',initial_litres='$initial',cur_litres='$current',updated_by='$upby',date_updated='$update',oil_type = '$oil' where pump_id = '$pumpid'";
            $pumpupdate = \Yii::$app->db->createCommand($q)->execute();

            if($pumpupdate)
            {
                \Yii::$app->session->setFlash('updp_success','Pump Updated Successfully');
                return $this->redirect(['pumpdet', 'pumpid' => $pumpid]);
                //return $this->redirect(['view', 'id' => $model->id]);
            }  else{
                \Yii::$app->session->setFlash('updp_fail','Failed,Please contact Administrator');
                return $this->render('_updpump', [
                    'model' => $model,'stations' =>$this->getStation(),
                    'otype' => $this->getOils(),'pumpid'=>$pumpid
                ]);
            }

        }

        return $this->renderAjax('_updpump', [
            'model' => $model,'stations' =>$this->getStation(),
            'otype' => $this->getOils(),'pumpid'=>$pumpid
        ]);
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

    protected function getOils()
    {
        $rg = Yii::$app->db->createCommand("select type_id,oil_type from oil_type")->queryAll(false);
        $OILArray = array();
        $OILArray[0] = 'Select Oil Type';
        foreach ($rg as $r) {
            $OILArray[$r[0]] = $r[1];
        }

        return $OILArray;
    }

    protected function getPumpdet($pumpid)
    {
        $pumpdt = Yii::$app->db->createCommand("select p.pump_id,p.pump_name,s.shell_name as station_name,concat(p.initial_litres,' litres') as initial_litres ,concat(p.cur_litres,' litres') as Available_litres,
        (select case a.cur_staff_assigned when 0 then 'Not Assigned' else concat(b.first_name,' ',b.last_name) end from pumps a left join tbl_user b on a.cur_staff_assigned=b.id where a.pump_id = '$pumpid') Assinged_to,
        concat(t.first_name,' ',t.last_name) created_by, date_format(p.crdate,'%M %d %Y') as created_date,o.oil_type from pumps p 
        inner join shells s on s.shell_id=p.station_id inner join tbl_user t on t.id=p.crby inner join oil_type o on o.type_id=p.oil_type where p.pump_id = '$pumpid'"
        )->queryOne(0);

        $tbP = "<table class='table table-condensed'>";
        $tbP .="<tr><th colspan='4' style='background-color: #d3d3d3'><b>Pump Details</b></th></tr>";
        $tbP .="<tr><th align='right'>Pump Name :</th><td>$pumpdt[1]</td><th align='right'>Station Name :</th><td>$pumpdt[2]</td></tr>";
        $tbP .="<tr><th align='right'>Initial Litres :</th><td>$pumpdt[3]</td><th align='right'>Available Litres :</th><td>$pumpdt[4]</td></tr>";
        $tbP .="<tr><th align='right'>Asigned To :</th><td>$pumpdt[5]</td><th align='right'>Oil Type :</th><td>$pumpdt[8]</td></tr>";
        $tbP .="<tr><th align='right'>Created By :</th><td>$pumpdt[6]</td><th align='right'>Created Date :</th><td>$pumpdt[7]</td></tr>";
        $tbP .="<tr><td align='right' colspan='2'><b>" . Html::button('<i class="fa fa-edit"></i> Update', ['value'=>Url::to(['stations/updpump','pumpid'=>$pumpdt[0]]),'title'=>'Update Pump Info','class' => 'showModalButton btn btn-success btn-md']) . "</b></td>";
        $tbP .="<td align='left' colspan='2'><b>" . Html::a('<i class="fa fa-trash-alt"></i> Delete', ['stations/delpump','pumpid'=>$pumpdt[0]], ['class' => 'btn btn-danger btn-md','data-confirm'=>'Are you sure you want to delete this pump ?']) . "</b></td></tr>";
        $tbP .="</table>";

        return $tbP;
    }

    public function actionDelpump($pumpid)
    {
        $has_sales =Yii::$app->db->createCommand("select count(*) from station_sells where pump_id = '$pumpid'")->queryScalar();

        if($has_sales > 0)
        {
            \Yii::$app->session->setFlash('delp_fail','Pump already have sales, It can not be deleted');
            return $this->redirect(['pumpdet', 'pumpid' => $pumpid]);
        }else{
            Yii::$app->db->createCommand("delete from pumps where pump_id = '$pumpid'")->execute();
            \Yii::$app->session->setFlash('delp_success','Pump deleted Successfully');
            return $this->redirect(['pumpdet', 'pumpid' => $pumpid]);
        }
    }

    /**
     * Deletes an existing Stations model.
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
     * Finds the Stations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
