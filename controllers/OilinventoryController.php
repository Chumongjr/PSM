<?php

namespace app\controllers;

use app\models\Tanks;
use Yii;
use app\models\OilInventory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * OilinventoryController implements the CRUD actions for OilInventory model.
 */
class OilinventoryController extends Controller
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
     * Lists all OilInventory models.
     * @return mixed
     */

    public function actionViewstations()
    {
        $slist = Yii::$app->db->createCommand("select s.shell_id,s.shell_name,s.location,s.no_pumps,CONCAT(t.first_name, ' ', t.last_name) supervisor
                    from shells s inner join tbl_user t on t.id=s.supervisor")->queryAll(0);

        $tbShells = "<table id='example1' class='table table-hover text-nowrap'>";
        $tbShells .="<thead><tr><th>SN</th><th>Station Name</th><th>Location</th><th>No. Pumps</th><th>Supervisor</th><th>Actions</th></tr></thead><tbody";
        $i=1;
        foreach ($slist as $list)
        {
            $tbShells .= "<tr><td>$i</td><td>$list[1]</td><td>$list[2]</td><td>$list[3]</td><td>$list[4]</td>";
            $tbShells .= "<td><b>" . Html::a('<i class="fa fa-eye"></i> View Detail', ['oilinventory/stdetails','stid'=>$list[0]], ['class' => 'btn btn-primary btn-xs']) . "</b></td></tr>";
            $i++;
        }
        $tbShells .="</tbody></table>";

        return $this->render('_slist',[
            'tbShells'=>$tbShells
        ]);
    }

    public function actionStdetails($stid)
    {
        $model = new Tanks();
        $tbTanks = '';


        $ss = "select t.tank_id,o.oil_type as name,s.shell_name,CONCAT(t.tank_capacity, ' Litres') tank_capacity,concat(t.available_litres,' Litres') available,
                ((t.available_litres * 100)/t.tank_capacity) summary,t.station_id
                from tanks t inner join oil_type o on t.oil_type=o.type_id inner join shells s on s.shell_id=t.station_id where t.station_id = '$stid'";
        $stanks = Yii::$app->db->createCommand($ss)->queryAll(0);
        $stname = Yii::$app->db->createCommand("select shell_name from shells where shell_id = :stid")->bindParam(':stid',$stid)->queryScalar();
        if(empty($stanks))
        {
            $tbTanks = "<table class='table text-nowrap'>";
            $tbTanks .="<tr><th>Station Tanks Summary</th></tr>";
            $tbTanks .="<tr><th><b>No tanks record please review..</b></th></tr></table>";
        }

        if(isset($_POST['btnAddtank']))
        {
            $model->load(Yii::$app->request->post());
            $oilt = $model->oil_type;
            $cap = $model->tank_capacity;
            $avl = $model->available_litres;
            $crby = \Yii::$app->user->id;
            $crdate = date('Y-m-d');

            $exist = Yii::$app->db->createCommand("select count(*) from tanks where station_id = :stid and oil_type = :oilt")->bindParam(':stid',$stid)->bindParam(':oilt',$oilt)->queryScalar();
            if($exist > 0)
            {
                \Yii::$app->session->setFlash('t_fail','Tank for Particular Oil Type Already Exist');
                return $this->redirect(['stdetails','stid'=>$stid]);
            }

            $q = "insert into tanks (oil_type,tank_capacity,available_litres,station_id,crby,crdate)values (:oilt,:cap,:avl,:station,:crby,:crdate)";
            $r = \Yii::$app->db->createCommand($q);
            $r->bindParam(":oilt",$oilt);
            $r->bindParam(":cap",$cap);
            $r->bindParam(":avl",$avl);
            $r->bindParam(":station",$stid);
            $r->bindParam(":crby",$crby);
            $r->bindParam(":crdate",$crdate);
            $r->execute();

            if($r)
            {
                \Yii::$app->session->setFlash('t_success','Tank Details addedSuccessfully');
            }  else{
                \Yii::$app->session->setFlash('t_fail','Failed,Please contact Administrator');
            }
            return $this->redirect(['stdetails','stid'=>$stid]);
        }

        return $this->render('_stdet',[
            'model'=>$model,'otype' => $this->getOiltype(),'stations' => $this->getStations(),
            'tbTanks'=>$tbTanks,'stanks'=>$stanks,'stname'=>$stname
        ]);
    }

    public function actionUpdtanks($tank,$station)
    {
        $model = new OilInventory();
        $modT = new Tanks();
        $summ = Yii::$app->db->createCommand("select distinct s.shell_name,o.oil_type from tanks t inner join oil_type o on t.oil_type=o.type_id inner join shells s on s.shell_id=t.station_id where t.tank_id = '$tank'")->queryOne(0);
        $avl = Yii::$app->db->createCommand("select tank_capacity,available_litres,oil_type from tanks where tank_id='$tank'")->queryOne(0);

        $model->avail_ltr = $avl[1];
        $modT->tank_capacity = $avl[0];

        if(isset($_POST['btnUpdtank']))
        {
            $model->load(Yii::$app->request->post());
            $addltr = $model->total_litres;
            $newltr = $avl[1] + $addltr;

            if($avl[0] < $newltr)
            {
                \Yii::$app->session->setFlash('upltr_fail','Added Litres exceed Tank capacity. The Tank holds '.$avl[0].' Litres');
                return $this->redirect(['updtanks','tank'=>$tank,'station'=>$station]);
            }
            $crby = \Yii::$app->user->id;
            $crdate = date('Y-m-d');

            $updtnk = Yii::$app->db->createCommand("update oil_inventory set iscurrent = 'N' where tank_id = '$tank' and station_id = '$station'")->execute();

            $q = "insert into oil_inventory (station_id,tank_id,oil_type,total_litres,crby,crdate)values (:station,:tank,:oilt,:ltrs,:crby,:crdate)";
            $r = \Yii::$app->db->createCommand($q);
            $r->bindParam(":station",$station);
            $r->bindParam(":tank",$tank);
            $r->bindParam(":oilt",$avl[2]);
            $r->bindParam(":ltrs",$addltr);
            $r->bindParam(":crby",$crby);
            $r->bindParam(":crdate",$crdate);
            $r->execute();

            if($r)
            {
                $uptnk = Yii::$app->db->createCommand("update tanks set available_litres = '$newltr' where tank_id = '$tank' and station_id = '$station'")->execute();

                \Yii::$app->session->setFlash('upltr_success','Tank Inventory Taken Successfully');
            }  else{
                \Yii::$app->session->setFlash('upltr_fail','Inventory Failed,Please contact Administrator');
            }
            return $this->redirect(['updtanks','tank'=>$tank,'station'=>$station]);

        }
        return $this->render('_updtank',[
            'model'=>$model,'modT'=>$modT,'otype' => $this->getOiltype(),'stations' => $this->getStations(),
            'station'=>$station,'tbInv'=>$this->getTankinv($tank,$station),'summ'=>$summ,
        ]);
    }

    public function actionReverse($tank,$station,$ltrs)
    {
        $avl = Yii::$app->db->createCommand("select tank_capacity,available_litres,oil_type from tanks where tank_id='$tank'")->queryOne(0);

        $newltr = $avl[1] - $ltrs;
        $uptnk = Yii::$app->db->createCommand("update tanks set available_litres = '$newltr' where tank_id = '$tank' and station_id = '$station'")->execute();
        if($uptnk)
        {
            $linv =Yii::$app->db->createCommand("select max(inv_id) from oil_inventory where tank_id = '$tank' and station_id = 'station' and iscurrent = 'N'")->queryScalar();

            Yii::$app->db->createCommand("delete from oil_inventory where iscurrent = 'Y' and tank_id = '$tank' and station_id='$station'")->execute();

            $updtnk = Yii::$app->db->createCommand("update oil_inventory set iscurrent = 'Y' where tank_id = '$tank' and station_id = '$station' and inv_id = '$linv'")->execute();

            if($updtnk)
            {
                \Yii::$app->session->setFlash('upltr_success','Tank Inventory Reversed Successfully');
            }  else{
                \Yii::$app->session->setFlash('upltr_fail','Inventory Reverse Failed,Please contact Administrator');
            }
            return $this->redirect(['updtanks','tank'=>$tank,'station'=>$station]);
        }
        return $this->redirect(['updtanks','tank'=>$tank,'station'=>$station]);
    }

    protected function getStations()
    {
        $range = Yii::$app->db->createCommand("select shell_id,shell_name from shells")->queryAll(false);
        $IDArray = array();
        $IDArray[0] = 'Select Station';
        foreach ($range as $rg) {
            $IDArray[$rg[0]] = $rg[1];
        }

        return $IDArray;
    }

    protected function getOiltype()
    {
        $rg = Yii::$app->db->createCommand("select type_id,oil_type from oil_type")->queryAll(false);
        $OILArray = array();
        $OILArray[0] = 'Select Oil Type';
        foreach ($rg as $r) {
            $OILArray[$r[0]] = $r[1];
        }

        return $OILArray;
    }

    public function getTankinv($tank,$station)
    {
        $t="select s.shell_name,o.oil_type,i.total_litres,CONCAT(t.first_name, ' ', t.last_name) sup,date_format(i.crdate,'%M %d %Y') crdate,
            i.tank_id,i.station_id,case i.iscurrent when 'Y' then 'Yes' when 'N' then 'No' end iscurrent
            from oil_inventory i
            inner join shells s on i.station_id = s.shell_id
            inner join tbl_user t on i.crby=t.id
            inner join oil_type o on i.oil_type=o.type_id
            where i.tank_id = '$tank' and i.station_id = '$station' order by i.inv_id desc";
        $invsum = Yii::$app->db->createCommand($t)->queryAll(0);

        $tbInv = "<table class='table table-hover text-nowrap'>";
        $tbInv .="<tr><th colspan='6'>Tank Inventory Summary</th></tr>";
        $tbInv .="<tr><th>SN</th><th>Station Name</th><th>Tank Name</th><th>Total Litres</th><th>Taken By</th><th>Inv Date</th><th>Is Current</th><th>Action</th></tr>";
        if(!empty($invsum))
        {
            $i=1;
            foreach ($invsum as $inv)
            {
                $tbInv .= "<tr><td>$i</td><td>$inv[0]</td><td>$inv[1]</td><td>$inv[2]</td><td>$inv[3]</td><td>$inv[4]</td><td>$inv[7]</td>";
                if($inv[7]=='Yes'){
                    $tbInv .= "<td><b>" . Html::a('<i class="fa fa-history"></i> Reverse', ['oilinventory/reverse','tank'=>$inv[5],'station'=>$inv[6],'ltrs'=>$inv[2]], ['class' => 'btn btn-warning btn-xs']) . "</b></td></tr>";
                }
                $i++;
            }
        }else{
            $tbInv .= "<tr><td colspan='6'>No Inventory Records</td></tr>";
        }
        $tbInv .="</table>";

        return $tbInv;
    }



    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OilInventory::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OilInventory model.
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
     * Creates a new OilInventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OilInventory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inv_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OilInventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inv_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OilInventory model.
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
     * Finds the OilInventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OilInventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OilInventory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
