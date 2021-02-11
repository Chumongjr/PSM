<?php

namespace app\controllers;

use app\models\Debtorsales;
use app\models\PaymentMethod;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use Yii;
use app\models\Debtors;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use kartik\mpdf\Pdf;

/**
 * DebtorsController implements the CRUD actions for Debtors model.
 */
class DebtorsController extends Controller
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
     * Lists all Debtors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Debtors();
        if(isset($_POST['btnsearchsupp']))
        {
            $model->load(Yii::$app->request->post());
            $debtor = strtolower(trim($model -> search_debtors));
            $debs = Yii::$app->db->createCommand("select debtor_id,debtor_code,debtor_name,address,email,contact_person from debtors where lower(debtor_name) like '%$debtor%'")->queryAll(0);
        }else{
            $debs = Yii::$app->db->createCommand("select debtor_id,debtor_code,debtor_name,address,email,contact_person from debtors")->queryAll(0);
        }

        $tbDebtors = "<table id='example1' class='table table-striped table-bordered'>";
        $tbDebtors .="<thead><tr><th>SN</th><th>Debtor Code</th><th>Debtor Name</th><th>Address</th><th>Email</th><th>Contact Person</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($debs as $deb)
        {
            $tbDebtors .= "<tr><td>$i</td><td>$deb[1]</td><td>$deb[2]</td><td>$deb[3]</td><td>$deb[4]</td><td>$deb[5]</td>";
            $tbDebtors .= "<td><b>" . Html::button('<i class="fa fa-edit"></i> Update Details', ['value'=>Url::to(['debtors/debtor-update','debid'=>$deb[0]]),'title'=>'Update Debtor Info','class' => 'showModalButton btn btn-success btn-xs']) . "</b> | ";
            $tbDebtors .= "<b>" . Html::a('<i class="fa fa-shopping-cart"></i> Make Order', ['debtors/debtor-order','debid'=>$deb[0]], ['class' => 'btn btn-info btn-xs']) . "</b></td></tr>";
            $i++;
        }
        $tbDebtors .="</tbody></table>";

        return $this->render('debtorslist', [
            'model' => $model,'tbDebtors'=>$tbDebtors,
        ]);
    }

    /**
     * Displays a single Debtors model.
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
     * Creates a new Debtors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Debtors();
        $model->debtor_code = $this->generateCode();
        $isupdt = false;
        if(isset($_POST['btnRegdeb']))
        {
            $model->load(Yii::$app->request->post());
            $debcod = $model->debtor_code;
            $debname = $model->debtor_name;
            $debadd = $model->address;
            $debtel = $model->tellephone;
            $debmeil = $model->Email;
            $debinv = $model->invoice_period;
            $devcontact =$model->contact_person;
            $contphon = $model->phone_no;
            $userid = Yii::$app->user->id;
            $cdate = date('Y/m/d');

            $r ="insert into debtors(debtor_code,debtor_name,address,tellephone,Email,contact_person,phone_no,invoice_period,crby,crdate) 
                values(:debcode,:debname,:debadd,:debtel,:debmail,:contname,:contphone,:debinv,:crby,:crdate)";
            $rc=Yii::$app->db->createCommand($r);
            $rc ->bindParam(':debcode',$debcod);
            $rc ->bindParam(':debname',$debname);
            $rc ->bindParam(':debadd',$debadd);
            $rc ->bindParam(':debtel',$debtel);
            $rc ->bindParam(':debmail',$debmeil);
            $rc ->bindParam(':contname',$devcontact);
            $rc ->bindParam(':contphone',$contphon);
            $rc ->bindParam(':debinv',$debinv);
            $rc ->bindParam(':crby',$userid);
            $rc ->bindParam(':crdate',$cdate);
            $rc ->execute();

            if($rc){
                Yii::$app->session->setFlash('success-createdeb','New Debtor Created Successfull');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('failed-createdeb','Debtor was not created. Please Contact Administrator');
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('regdebtor', [
            'model' => $model,'isupdt'=>$isupdt
        ]);
    }

    /* generate new debtor code on every new debtors registration*/
    public function generateCode()
    {
        $new_code = '';
        $lastid = Yii::$app->db->createCommand('select max(debtor_id) from debtors')->queryScalar();

        if(empty($lastid))
        {
            $new_code = 'Debtor:1000';
        }else{
            $last_code= Yii::$app->db->createCommand('select debtor_code from debtors where debtor_id = :lastid')->bindParam(':lastid',$lastid)->queryScalar();
            $expl = explode(":",$last_code);
            $newno = $expl[1] + 1;
            $new_code = $expl[0].':'.$newno;
        }

        return $new_code;
    }

    public function generateDate($debinv,$debid)
    {
        $iexist = Yii::$app->db->createCommand("select count(*) from debtor_sales where invoice_no = '$debinv'")->queryScalar();
        if($iexist < 1)
        {
            $ddate = date('Y/m/d');
        }else{
            $ddate = Yii::$app->db->createCommand("select crdate from debtor_sales where invoice_no = '$debinv'")->queryScalar();
        }
        $dday = Yii::$app->db->createCommand("select case invoice_period when 1 then 7 when 2 then 15 when 3 then 30 end  from debtors where debtor_id = '$debid'")->queryScalar();
        $time = strtotime($ddate);
        $newTime = $time + $dday * 60 * 60 * 24;
        $newDate = date('d-M-Y', $newTime);

        return $newDate;
    }

    public function actionDebtorOrder($debid)
    {
        $haspending = Yii::$app->db->createCommand("select count(*) from debtor_sales where status != 'P' and debtor_id = '$debid'")->queryScalar();
        if($haspending > 0)
        {
            Yii::$app->session->setFlash('failed-createdeb','Debtor has a pending Unpaid Invoice Billed.');
            return $this->redirect(['index']);
        }
        $model = new Debtors();

        $debdet=Yii::$app->db->createCommand("select contact_person,debtor_name,address,email,phone_no from debtors where debtor_id = '$debid'")->queryOne(0);
        $debinv = $this->generateInvno($debid);
        $otype = $this->getOils();
        $stations = $this->getStations();
        $dorderTB = $model->getOrder($debinv);
        $invend = $this->generateDate($debinv,$debid);
        $invtotal = Yii::$app->db->createCommand("select coalesce(sum(total_litres),0),coalesce(sum(total_sale),0) from debtor_sales_oil  where invoice_no = $debinv")->queryOne(0);

        $ddate = Yii::$app->db->createCommand("select crdate from debtor_sales where invoice_no = $debinv")->queryScalar();
        if(empty($ddate)){ $ddate = date('d-M-Y');}

        if(isset($_POST['btnAdd']))
        {
            $model->load(Yii::$app->request->post());
            $userid = Yii::$app->user->id;
            $station = $model->station;
            $type = $model->oil_type;
            $ltrs = $model->total_litre;
            $iscomplete = 'No';
            $isupdate = 'No';

            $dorder = Yii::$app->db->createCommand("select fn_addbill('$debid',$station,'$iscomplete',$type,$userid,$debinv,$ltrs,'$isupdate') from dual")->queryScalar();

            if(!empty($dorder))
            {
                $debinv = $dorder;
                $dorderTB = $model->getOrder($debinv);
                $model->station = $station;
            }
            return $this->redirect(['debtor-order','debid'=>$debid]);
        }

        return $this->render('_debtor_order',[
            'model'=>$model,'debdet'=>$debdet,'otype'=>$otype,'invtotal'=>$invtotal,
            'debid'=>$debid,'debinv'=>$debinv,'stations'=>$stations,
            'dorderTB'=>$dorderTB,'invend'=>$invend,'ddate'=>$ddate,
        ]);
    }

    protected function getStations()
    {
        $userid = Yii::$app->user->id;
        $rg = Yii::$app->db->createCommand("SELECT shell_id,shell_name FROM SHELLS where supervisor = '$userid'")->queryAll(false);
        $OILArray = array();
        $OILArray[0] = 'Select Station';
        foreach ($rg as $r) {
            $OILArray[$r[0]] = $r[1];
        }

        return $OILArray;
    }

    protected function getPaym()
    {
        $rg = Yii::$app->db->createCommand("SELECT payment_id,payment_method FROM payment_method")->queryAll(false);
        $PMethod = array();
        $PMethod[0] = 'Select Payment Mode';
        foreach ($rg as $r) {
            $PMethod[$r[0]] = $r[1];
        }

        return $PMethod;
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

    /* generate new invoice code on every new debtors registration*/
    public function generateInvno($debid)
    {
        $new_code = '';
        $lastid = Yii::$app->db->createCommand('select max(dbs_id) from debtor_sales_oil')->queryScalar();
        if(empty($lastid))
        {
            $new_code = '11111';
        }else{
            //checkin if there is an existing pending invoice
            $new_code = Yii::$app->db->createCommand('select distinct invoice_no from debtor_sales_oil where debtor_id = :debid and billcompleted is null')->bindParam(':debid',$debid)->queryScalar();
            if(empty($new_code)){
                $last_code= Yii::$app->db->createCommand('select invoice_no from debtor_sales_oil where dbs_id = :lastid')->bindParam(':lastid',$lastid)->queryScalar();
                $new_code = $last_code + 1;
            }
        }

        return $new_code;
    }

    public function actionEdorderunit($dedid)
    {
        $model = new Debtors();
        $dets = Yii::$app->db->createCommand("select oil_type,invoice_no,debtor_id,station_id,total_litres from debtor_sales_oil where dbs_id = :debid")->bindParam(':debid',$dedid)->queryOne(0);
        $model->total_litre = $dets[4];

        if(isset($_POST['btndupdate']))
        {

            $model->load(Yii::$app->request->post());
            $userid = Yii::$app->user->id;
            $newl = $model->total_litre;
            $iscomplete = 'No';
            $isupdate = 'Yes';

            $dorder = Yii::$app->db->createCommand("select fn_addbill($dets[2],$dets[3],'$iscomplete',$dets[0],$userid,$dets[1],$newl,'$isupdate') from dual")->queryScalar();

            if(!empty($dorder))
            {
                return $this->redirect(['debtors/debtor-order','debid'=>$dets[2]]);
            }
        }

        return $this->renderAjax('_edit_orders',[
            'model'=>$model,
        ]);
    }

    public function actionRmorderunit($dedid)
    {
        $model = new Debtors();
        $dets = Yii::$app->db->createCommand("select oil_type,invoice_no,debtor_id,station_id,total_litres from debtor_sales_oil where dbs_id = :debid")->bindParam(':debid',$dedid)->queryOne(0);

        Yii::$app->db->createCommand("delete from debtor_sales_oil where dbs_id = :dbsid")->bindParam(':dbsid',$dedid)->execute();

        return $this->redirect(['debtors/debtor-order','debid'=>$dets[2]]);
    }

    public function actionTransfercomplete($debid,$debinv)
    {
        $model = new Debtors();
        $userid = Yii::$app->user->id;
        $iscomplete = 'Complete';
        $com_order = Yii::$app->db->createCommand("select fn_completebill($debid,$debinv,$userid,'$iscomplete') from dual")->queryScalar();

        $expl = explode(":",$com_order);
        if($expl[1]=='failed')
        {
            Yii::$app->session->setFlash('scomplete_fail',$expl[0]);
            return $this->redirect(['debtor-order','debid'=>$debid]);
        }else{
            Yii::$app->session->setFlash('scomplete_sucess',$expl[0]);
            return $this->redirect(['index']);
        }
    }

    public function actionBills()
    {
        $l = "select d.debtor_code,d.debtor_name,s.invoice_no,total_litres,total_sale,
                case s.status when 'C' then 'Invoice Created' when 'I' then 'Partial Payment' when 'P' then 'Paid' end bill_status
                from debtor_sales s
                inner join debtors d on d.debtor_id=s.debtor_id where s.status in ('C','I')";
        $lbill = Yii::$app->db->createCommand("$l")->queryAll(0);
        $bgroup = 'Pending';
        $tbBills = "<table id='example1' class='table table-striped table-bordered'>";
        $tbBills .="<thead><tr><th>SN</th><th>Debtor Code</th><th>Debtor Name</th><th>Litres</th><th>Total Amount</th><th>Invoice</th><th>Status</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($lbill as $lb)
        {
            $tbBills .= "<tr><td>$i</td><td>$lb[0]</td><td>$lb[1]</td><td>".number_format($lb[3])."</td><td>".number_format($lb[4],2)."</td><td>$lb[2]</td>";
            if($lb[5] == 'Invoice Created' ){
                $tbBills .="<td><span class='badge badge-danger'>Invoice Created</span></td>";
            }else{
                $tbBills .="<td><span class='badge badge-warning'>Partial Payment</span></td>";
            }
            $tbBills .= "<td><b>" . Html::a('<i class="fa fa-eye"></i> View Detail', ['debtors/invoice-bill','invid'=>$lb[2]]) . "</b></td></tr>";
            $i++;
        }
        $tbBills .="</tbody></table>";

        return $this->render('bill_list',[
            'tbBills'=>$tbBills,'bgroup'=>$bgroup
        ]);
    }

    public function actionPaidBills()
    {
        $l = "select d.debtor_code,d.debtor_name,s.invoice_no,total_litres,total_sale,
                case s.status when 'C' then 'Invoice Created' when 'I' then 'Partial Payment' when 'P' then 'Paid' end bill_status
                from debtor_sales s
                inner join debtors d on d.debtor_id=s.debtor_id where s.status = 'P'";
        $lbill = Yii::$app->db->createCommand("$l")->queryAll(0);
        $bgroup = 'Paid';
        $tbBills = "<table id='example1' class='table table-striped table-bordered'>";
        $tbBills .="<thead><tr><th>SN</th><th>Debtor Code</th><th>Debtor Name</th><th>Litres</th><th>Total Amount</th><th>Invoice</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($lbill as $lb)
        {
            $tbBills .= "<tr><td>$i</td><td>$lb[0]</td><td>$lb[1]</td><td>".number_format($lb[3])."</td><td>".number_format($lb[4],2)."</td><td>$lb[2]</td>";
            $tbBills .= "<td><b>" . Html::a('<i class="fa fa-eye"></i> View Detail', ['debtors/invoice-bill','invid'=>$lb[2]]) . "</b></td></tr>";
            $i++;
        }
        $tbBills .="</tbody></table>";

        return $this->render('bill_list',[
            'tbBills'=>$tbBills,'bgroup'=>$bgroup
        ]);
    }

    public function actionInvoiceBill($invid)
    {
        $model = new Debtors();

        $invdet = Yii::$app->db->createCommand("select debtor_id,date_format(crdate,'%d-%b-%Y'),total_litres,total_sale,status,coalesce(paid_amount,0) paid,coalesce((total_sale - coalesce(paid_amount,0)),0 ) remain
                                                    from debtor_sales where invoice_no = $invid")->queryOne(0);
        $debdet=Yii::$app->db->createCommand("select contact_person,debtor_name,address,email,phone_no from debtors where debtor_id = '$invdet[0]'")->queryOne(0);
        $invend = $this->generateDate($invid,$invdet[0]);
        $dorderTB = $model->getCompleteOrder($invid);


        return $this->render('billinvoice',[
            'model'=>$model,'debdet'=>$debdet,'invend'=>$invend,'invdet'=>$invdet,
            'dorderTB'=>$dorderTB,'invid'=>$invid,
        ]);
    }

    public function actionBillpayment($invid)
    {
        $model = new Debtorsales();
        $pmethod = $this->getPaym();

        if(isset($_POST['btnmakepay']))
        {
            $model->load(Yii::$app->request->post());
            $userid = Yii::$app->user->id;
            $pamount = $model->paid_amount;
            $ptype = $model->payment_type;
            $pmetd = $model->payment_method;

            $q = "CALL sp_bill_payment(:p_invoiceno,:p_payamount,:p_paytype,:p_paymethod,:p_crby,@Msg)";
            $cmd = Yii::$app->db->createCommand($q);
            $cmd->bindValue(':p_invoiceno', $invid);
            $cmd->bindValue(':p_payamount', $pamount);
            $cmd->bindValue(':p_paytype', $ptype);
            $cmd->bindValue(':p_paymethod', $pmetd);
            $cmd->bindValue(':p_crby', $userid);
            $cmd->execute();

            $message = Yii::$app->db->createCommand("select @Msg as result;")->queryScalar();

            $r = explode(":", $message);
            if ($r[1] == 'Success') {
                Yii::$app->session->setFlash('success-makepay', $r[0]);
            }else{
                Yii::$app->session->setFlash('failed-makepay', $r[0]);
            }
            return $this->redirect(['invoice-bill','invid'=>$invid]);
        }
        return $this->renderAjax('_bill_payment',[
            'model'=>$model,'pmethod'=>$pmethod
        ]);
    }

    public function actionReverseBill($invid)
    {
        $has_paid = Yii::$app->db->createCommand("select count(*) from debtor_sales where invoice_no = $invid and status = 'C'")->queryScalar();
        if($has_paid > 0)
        {
            $saudit = $this->getreversed($invid);

            if($saudit = 'Ok')
            {
                $revdts =  Yii::$app->db->createCommand("update debtor_sales_oil set debtorsales_id = null,billcompleted = null where invoice_no = $invid")->execute();
                if($revdts){
                    Yii::$app->db->createCommand("delete from debtor_sales where invoice_no = $invid")->execute();

                    Yii::$app->session->setFlash('rev_success','Bill Reversed Successfully, Now You can Update bill Details');
                    return $this->redirect(['bills']);
                }else{
                    Yii::$app->session->setFlash('rev_fail','Reverse of Bill fail to update Bill Detail please contact System Admin');
                    return $this->redirect(['invoice-bill','invid'=>$invid]);
                }
            }else{
                Yii::$app->session->setFlash('rev_fail','Reverse of Bill failed.System failed to Capture Bill Detail, Please contact System Admin');
                return $this->redirect(['invoice-bill','invid'=>$invid]);
            }
        }else{
            Yii::$app->session->setFlash('rev_fail','This Bill has been Paid. Your not allowed to REVERSE it.');
            return $this->redirect(['invoice-bill','invid'=>$invid]);
        }
    }

    protected function getreversed($invid)
    {
        $user=Yii::$app->user->id;
        $d = date('Y-m-d H:m:s');

        $r = "select debtorsale_id,debtor_id,station_id,total_litres,total_sale,status,invoice_no,crby,crdate from debtor_sales where invoice_no = :invid";
        $rvs = Yii::$app->db->createCommand($r)->bindParam(':invid',$invid)->queryOne(0);

        $rev = "insert into reversed_debtor_sales(debtorsale_id,debtor_id,station_id,total_litres,total_sale,status,invoice_no,crby,crdate,reversed_by,reversed_date)
                values(:dbid,:debtorid,:statid,:totl,:tots,:status,:inv,:crby,:crdate,:revby,:revdate)";
        $insert_revs = Yii::$app->db->createCommand($rev);
        $insert_revs->bindParam(':dbid',$rvs[0]);
        $insert_revs->bindParam(':debtorid',$rvs[1]);
        $insert_revs->bindParam(':statid',$rvs[2]);
        $insert_revs->bindParam(':totl',$rvs[3]);
        $insert_revs->bindParam(':tots',$rvs[4]);
        $insert_revs->bindParam(':status',$rvs[5]);
        $insert_revs->bindParam(':inv',$rvs[6]);
        $insert_revs->bindParam(':crby',$rvs[7]);
        $insert_revs->bindParam(':crdate',$rvs[8]);
        $insert_revs->bindParam(':revby',$user);
        $insert_revs->bindParam(':revdate',$d);
        $insert_revs->execute();

        if($insert_revs){
            return 'Ok';
        }else{
            return 'Failed';
        }
    }

    public function actionPayMethods()
    {
        $model = new PaymentMethod();
        $tbP = $this->getpaymethods();

        if(isset($_POST['btnpmethod']))
        {
            $model->load(Yii::$app->request->post());
            $pmethod = $model->payment_method;

            $cr = Yii::$app->db->createCommand("insert into payment_method(payment_method)values(:pmethod)")->bindParam(':pmethod',$pmethod)->execute();
            if($cr)
            {
                Yii::$app->session->setFlash('success-crmethod','Payment Method Added Successfull');
                return $this->redirect(['pay-methods']);
            }
        }
        return $this->render('paymethod',[
            'model'=>$model,'tbP'=>$tbP
        ]);
    }

    protected function getpaymethods()
    {
        $getPemethod = Yii::$app->db->createCommand("select payment_id,payment_method from payment_method")->queryAll(0);
        $tbP = "<table id='example1' class='table table-striped table-bordered'>";
        $tbP .="<thead><tr><th>SN</th><th>Payment Method</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($getPemethod as $p)
        {
            $tbP .= "<tr><td>$i</td><td>$p[1]</td><td><b>" . Html::a('<i class="fa fa-trash-alt"></i> Remove', ['debtors/rmpayment','pid'=>$p[0]],['class'=>'btn btn-danger btn-sm','onClick'=>'return confirm(" Are you sure you want to remove this")']) . "</b></td></tr>";
            $i++;
        }
        $tbP .="</tbody></table>";

        return $tbP;
    }

    public function actionRmpayment($pid)
    {
        $remove = Yii::$app->db->createCommand("delete from payment_method where payment_id = :pid")->bindParam(':pid',$pid)->execute();

        Yii::$app->session->setFlash('success-rmpay','Payment Method Removed Successfull');
        return $this->redirect(['pay-methods']);

    }

    /**
     * Updates an existing Debtors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDebtorUpdate($debid)
    {
        $model = $this->findModel($debid);
        $isupdt = true;
        if(isset($_POST['btnUpdtdeb']))
        {
            $model->load(Yii::$app->request->post());

            $debcod = $model->debtor_code;
            $debname = $model->debtor_name;
            $debadd = $model->address;
            $debtel = $model->tellephone;
            $debmeil = $model->Email;
            $debinv = $model->invoice_period;
            $devcontact =$model->contact_person;
            $contphon = $model->phone_no;
            $userid = Yii::$app->user->id;
            $cdate = date('Y/m/d H:m:s');

            $r = "update debtors set debtor_name = :debname,address = :debadd,tellephone=:debtel,Email= :debmail,contact_person=:contname,phone_no=:contphone,invoice_period = :debinv,updated_by= :crby,updated_date=:crdate where debtor_id = $debid";
            $rc=Yii::$app->db->createCommand($r);
            $rc ->bindParam(':debname',$debname);
            $rc ->bindParam(':debadd',$debadd);
            $rc ->bindParam(':debtel',$debtel);
            $rc ->bindParam(':debmail',$debmeil);
            $rc ->bindParam(':contname',$devcontact);
            $rc ->bindParam(':contphone',$contphon);
            $rc ->bindParam(':debinv',$debinv);
            $rc ->bindParam(':crby',$userid);
            $rc ->bindParam(':crdate',$cdate);
            $rc ->execute();

            if($rc){
                Yii::$app->session->setFlash('success-createdeb','Debtor Information Updated Successfull');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('failed-createdeb','Debtor was not updated. Please Contact Administrator');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('regdebtor', [
            'model' => $model,'isupdt'=>$isupdt
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Debtors::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrintInvoice($invid)
    {
        $model = new Debtors();

        $invdet = Yii::$app->db->createCommand("select debtorsale_id,debtor_id,date_format(crdate,'%d-%b-%Y'),total_litres,total_sale,status,coalesce(paid_amount,0) paid,coalesce((total_sale - coalesce(paid_amount,0)),0 ) remain
                                                    from debtor_sales where invoice_no = $invid")->queryOne(0);
        $debdet=Yii::$app->db->createCommand("select contact_person,debtor_name,address,email,phone_no from debtors where debtor_id = '$invdet[1]'")->queryOne(0);
        $invend = $this->generateDate($invid,$invdet[0]);
        $dorderTB = $model->getCompleteOrder($invid);
        $compdet = Yii::$app->db->createCommand("select c.company_no,c.company_name,c.address,c.company_tel,c.email,c.contact_person,c.phone_no,c.location,c.bank_acc,b.bank_name
                                                  from company_profile c inner join banks b on c.bank_name=b.bank_id")->queryOne(0);

        $content = $this->renderPartial('invoice',[
            'model'=>$model,'debdet'=>$debdet,'invend'=>$invend,'invdet'=>$invdet,
            'dorderTB'=>$dorderTB,'invid'=>$invid,'compdet'=>$compdet]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            //'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            //'cssFile'=>'@vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css',
            // any css to be embedded if required
            'cssInline' => '.ribbon-inner {
                            text-align:center;
                            -webkit-transform:rotate(45deg);
                            -moz-transform:rotate(45deg);
                            -ms-transform:rotate(45deg);
                            -o-transform:rotate(45deg);
                            position:relative;
                            padding:7px 0;
                            left:-5px;
                            top:11px;
                            width:120px;
                            background-color:#66c591;
                            font-size:15px;
                            color:#fff;
                        }
                        
                        .ribbon-inner:before,.ribbon-inner:after {
                            content:"";
                            position:absolute;
                        }
                        
                        .ribbon-inner:before {
                            left:0;
                        }
                        
                        .ribbon-inner:after {
                            right:0;
                        }',
            // set mPDF properties on the fly
            //'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            //'methods' => [
            //    'SetHeader'=>['Krajee Report Header'],
            //    'SetFooter'=>['{PAGENO}'],
            //]
        ]);
        return $pdf->render();

        /* return $this->render('_invoice',[
             'model'=>$model,'debdet'=>$debdet,'invend'=>$invend,'invdet'=>$invdet,
             'dorderTB'=>$dorderTB,'invid'=>$invid,'compdet'=>$compdet
         ]);*/
    }

    public function actionPrintReceipt($invid)
    {
        $model = new Debtors();

        $invdet = Yii::$app->db->createCommand("select debtorsale_id,debtor_id,date_format(crdate,'%d-%b-%Y'),total_litres,total_sale,status,coalesce(paid_amount,0) paid,coalesce((total_sale - coalesce(paid_amount,0)),0 ) remain
                                                    from debtor_sales where invoice_no = $invid")->queryOne(0);
        $debdet=Yii::$app->db->createCommand("select contact_person,debtor_name,address,email,phone_no from debtors where debtor_id = '$invdet[1]'")->queryOne(0);
        $invend = $this->generateDate($invid,$invdet[0]);
        $dorderTB = $model->getCompleteOrder($invid);
        $compdet = Yii::$app->db->createCommand("select c.company_no,c.company_name,c.address,c.company_tel,c.email,c.contact_person,c.phone_no,c.location,c.bank_acc,b.bank_name
                                                  from company_profile c inner join banks b on c.bank_name=b.bank_id")->queryOne(0);

        $content = $this->renderPartial('receipt',[
            'model'=>$model,'debdet'=>$debdet,'invend'=>$invend,'invdet'=>$invdet,
            'dorderTB'=>$dorderTB,'invid'=>$invid,'compdet'=>$compdet]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'cssInline'=>'
                .cycle {
                  position: absolute;
                  left: 50%;
                  right: 50%;
                  transform: translate(-50%,-50%);
                  width: 300px;
                  height: 300px;
                  background: black;
                  border-radius: 50%;
                }',

        ]);
        return $pdf->render();
    }

    protected function autoReport()
    {
        $con = Yii::$app->db;
        $yesterday = date('d/m/Y',strtotime("-1 days"));
        $query = "select l.shell_name,sum(litre_sold) as Total_litres,sum(total_sell) Total_sell,s.station_id
                        from station_sells s
                        inner join  shells l on l.shell_id=s.station_id
                        where s.crdate = STR_TO_DATE('$yesterday', '%d/%m/%Y')
                        and s.iscurrent = 'N'
                        group by l.shell_name";
        $daysales = $con->createCommand($query)->queryAll(0);
        $company_name = $con->createCommand("select company_name from company_profile")->queryScalar();


        $pdf = new Yii::$app->pdf;
        $reportFile = 'reports/'.$company_name.'-'. strtotime(date('Y-m-d H:i:s')) . '-sales.pdf';
        $htmlContent = $this->renderPartial('auto_report',[
            'daysales'=>$daysales,'yesterday'=>$yesterday
        ]);
        $pdf->content = $htmlContent;
        $pdf->filename = $reportFile;
        $pdf->cssFile = '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css';
        $pdf->destination = 'F';
        $pdf->methods = [
            'SetTitle' => 'Daily Sales Report',
            'SetSubject' => 'Daily Sales Report',
            'SetHeader' => ['Sales Report ||Generated On: ' . date("r")],
            'SetFooter' => ['|Page {PAGENO}|'],
            //'SetAuthor' => 'Stroils Petroleam',
           // 'SetCreator' => 'Stroils Petroleam'
        ];
        $pdf->render();

    }

    public function actionSendMails()
    {
        $con = Yii::$app->db;
        $yesterday = date('d/m/Y',strtotime("-1 days"));
        $getattchment = $this->autoReport();
        $company_name = $con->createCommand("select company_name from company_profile")->queryScalar();
        $reportFile = 'reports/'.$company_name.'-'. strtotime(date('Y-m-d H:i:s')) . '-sales.pdf';
        $mail = $con->createCommand("select first_name,email from tbl_user where groupid = 2")->queryOne(0);

        $message = '<div class="site-index">';
        $message .= '<h5>Hello '. $mail[0].',</h5>';
        $message .= '<p>This is email is attached with sales report for <strong>'.$yesterday .'</strong>.</p>';
        $message .= '<p>Thank you, <br>';
        $message .= '<p>'. $company_name .'</p><br>' ;
        $message .= '</p><br><br><br><br>';
        $message .= '<p style="font-family: \'Courier New\'; font-size:11px"><i>This is an automated message - please do not reply directly to this email.</i></p></div>';

        //sending mail
        $mailer = Yii::$app->mailer->compose()
            ->setTo($mail[1])
            ->setFrom(['stroilstz@gmail.com' => 'Stroils Petrolium'])
            ->setSubject('Daily Sales Report '.$company_name)
            ->setHtmlBody($message);
        $mailer->attach($reportFile);
        $mailer->send();

        if($mailer)
        {
            unlink($reportFile);
        }
        return 1;
    }
}