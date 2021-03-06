<?php

namespace app\controllers;

use app\models\CompanyProfile;
use Yii;
use app\models\User;
use app\models\Positions;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $model = new User();

        $r = "select id,first_name,last_name,email,case groupid when 1 then 'Admin' when 2 then 'Manager' when 3 then 'Supervisor' when 4 then 'Staffs'end user_group,
                case status when 'A' then 'Active' when 'S' then 'Suspended' when 'L' then 'Locked' end status from tbl_user";
        $us = Yii::$app->db->createCommand($r)->queryAll(0);

        $tbUsers ="<table id='example1' class='table table-striped table-bordered'>";
        $tbUsers .="<thead><tr><th>SN</th><th>First Name</th><th>Last Name</th><th>Email</th><th>User Group</th><th>Status</th><th>Action</th></tr></thead><tbody>";
        $i = 1;
        foreach ($us as $u) {
            $tbUsers .="<tr><td>$i</td><td>$u[1]</td><td>$u[2]</td><td>$u[3]</td><td>$u[4]</td><td>$u[5]</td>";
            $tbUsers .= "<td><b>" . Html::a('<i class="fa fa-eye"></i> View Profile', ['users/profile','id'=>$u[0]], ['class' => 'btn btn-primary btn-xs']) . "</b></td></tr>";
            $i++;
        }
        $tbUsers .="</tbody></table>";

        return $this->render('list', [
            'tbUser'=>$tbUsers,'model'=>$model,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if(isset($_POST['btnReguser']))
        {
            //$model ->load(Yii::$app->request->post());
            $model->load(\Yii::$app->getRequest()->post());
            $fname = $model->first_name;
            $lname = $model->last_name;
            $mail = $model->email;
            $username = $model->username;
            $grp = $model->groupid;
            $password = $model->passwd;
            $cby = \Yii::$app->user->id;
            $cdate = date('Y-m-d');
            $new_pass = \Yii::$app->security->generatePasswordHash($password);
            $key = \Yii::$app->security->generateRandomString();

            $q = "insert into tbl_user (first_name,last_name,email,password,auth_key,created_by,created_date,username,groupid)values (:fname,:lname,:mail,:password,:key,:cby,:cdate,:username,:grp)";
            $r = \Yii::$app->db->createCommand($q);
            $r->bindParam(":fname",$fname);
            $r->bindParam(":lname",$lname);
            $r->bindParam(":mail",$mail);
            $r->bindParam(":password",$new_pass);
            $r->bindParam(":key",$key);
            $r->bindParam(":cby",$cby);
            $r->bindParam(":cdate",$cdate);
            $r->bindParam(":username",$username);
            $r->bindParam(":grp",$grp);
            $r->execute();

            if($r)
            {
                \Yii::$app->session->setFlash('reg_success','User Account Create Successfully');
            }  else{
                \Yii::$app->session->setFlash('reg_fail','Failed,Please contact Administrator');
            }
            return $this->render('reguser', [
                'model' => $model,
            ]);
        }


        return $this->render('reguser', [
            'model' => $model,'action'=> 'create',
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new User();

        $det = $this->getUser($id);
        $model->first_name = $det[0];
        $model->last_name = $det[1];
        $model->email = $det[2];
        $model->username = $det[3];
        $model->status = $det[4];
        $model->groupid = $det[5];


        if(isset($_POST['btnUpdReguser']))
        {
            $model->load(Yii::$app->request->post());
            $fn = $model->first_name;
            $ln = $model->last_name;
            $user = $model->username;
            $mail = $model->email;
            $grpid = $model->groupid;
            $status = $model->status;
            //echo $status; exit;
            $eby = \Yii::$app->user->id;
            $edate = date('Y-m-d');

            $r = "update tbl_user set first_name = '$fn',last_name='$ln',email='$mail',username='$user',status='$status',groupid='$grpid',edited_by ='$eby',edited_date='$edate' where id = '$id'";
            $upd = \Yii::$app->db->createCommand($r)->execute();

            if($upd)
            {
                \Yii::$app->session->setFlash('upd_success','User Account Updated Successfully');
                return $this->redirect(['profile','id'=>$id]);
            }  else{
                \Yii::$app->session->setFlash('upd_fail','Failed to update,Please contact Administrator');
                return $this->redirect(['profile','id'=>$id]);
            }

        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    public function actionProfile($id)
    {
        $r = "select first_name,last_name,email,username,case status when 'A' then 'Active' when 'S' then 'Suspended' end Status,
              case groupid when 1 then 'Admin' when 2 then 'Manager' when 3 then 'Supervisor' when 4 then 'Staff' end usertype  from tbl_user where id = '$id'";
        $userdet = Yii::$app->db->createCommand($r)->queryOne(0);

        return $this->render('profile_details',[
                'id'=>$id,'userdet'=>$userdet,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function getUser($id)
    {
        $gtuser = Yii::$app->db->createCommand("select first_name,last_name,email,username,status,groupid from tbl_user where id = '$id'")->queryOne(0);

        return $gtuser;
    }

    public function actionCompProfile()
    {
        $modProfile = new CompanyProfile();
        $has_profile = Yii::$app->db->createCommand("select count(*) from company_profile")->queryScalar();

        $compdet = Yii::$app->db->createCommand("select c.company_no,c.company_name,c.address,c.company_tel,c.email,c.contact_person,c.phone_no,c.location,c.bank_acc,b.bank_name
                                                    from company_profile c inner join banks b on c.bank_name=b.bank_id")->queryOne(0);
        if($has_profile > 0 ){$pview = 'camp_profile';}else{ $pview = 'add_campprof';}

        if(isset($_POST['btnRegc']))
        {
            $modProfile->load(Yii::$app->request->post());

            $cname = $modProfile->company_name;
            $cadd = $modProfile->address;
            $ctel = $modProfile->company_tel;
            $cmail = $modProfile->email;
            $cperson =$modProfile->contact_person;
            $contphon = $modProfile->phone_no;
            $cloc = $modProfile->location;
            $cbank_acc = $modProfile->bank_acc;
            $cbank = $modProfile->bank_name;

            $r ="insert into company_profile(company_name,address,company_tel,email,contact_person,phone_no,location,bank_acc,bank_name) 
                values(:cname,:cadd,:ctel,:cmail,:cperson,:contphone,:cloc,:cbank_acc,:cbank)";
            $rc=Yii::$app->db->createCommand($r);
            $rc ->bindParam(':cname',$cname);
            $rc ->bindParam(':cadd',$cadd);
            $rc ->bindParam(':ctel',$ctel);
            $rc ->bindParam(':cmail',$cmail);
            $rc ->bindParam(':cperson',$cperson);
            $rc ->bindParam(':contphone',$contphon);
            $rc ->bindParam(':cloc',$cloc);
            $rc ->bindParam(':cbank_acc',$cbank_acc);
            $rc ->bindParam(':cbank',$cbank);
            $rc ->execute();

            if($rc){
                Yii::$app->session->setFlash('success-createc','New Debtor Created Successfull');
                return $this->redirect(['comp-profile']);
            }else{
                Yii::$app->session->setFlash('failed-createc','Debtor was not created. Please Contact Administrator');
                return $this->redirect(['comp-profile']);
            }
        }

        return $this->render($pview,[
            'modProfile'=>$modProfile, 'has_profile'=>$has_profile,
            'compdet'=>$compdet,
        ]);
    }

    public function actionUpdComp($compid)
    {
        $modProfile = new CompanyProfile();
        $cmp = Yii::$app->db->createCommand("select * from company_profile where company_no = :comp")->bindParam(':comp',$compid)->queryOne(0);

        $modProfile->company_name = $cmp[1];
        $modProfile->address = $cmp[2];
        $modProfile->company_tel = $cmp[3];
        $modProfile->email = $cmp[4];
        $modProfile->contact_person = $cmp[5];
        $modProfile->phone_no = $cmp[6];
        $modProfile->location = $cmp[7];
        $modProfile->bank_acc = $cmp[8];
        $modProfile->bank_name = $cmp[8];

        if(isset($_POST['btnUpdc']))
        {
            $modProfile->load(Yii::$app->request->post());

            $cname = $modProfile->company_name;
            $cadd = $modProfile->address;
            $ctel = $modProfile->company_tel;
            $cmail = $modProfile->email;
            $cperson =$modProfile->contact_person;
            $contphon = $modProfile->phone_no;
            $cloc = $modProfile->location;
            $cbank_acc = $modProfile->bank_acc;
            $cbank = $modProfile->bank_name;

            $r ="update company_profile set company_name = :cname,address= :cadd,company_tel=:ctel,email=:cmail,contact_person=:cperson,phone_no=:contphone,location=:cloc,bank_acc=:cbank_acc,bank_name=:cbank where company_no = :compid";
            $rc=Yii::$app->db->createCommand($r);
            $rc ->bindParam(':cname',$cname);
            $rc ->bindParam(':cadd',$cadd);
            $rc ->bindParam(':ctel',$ctel);
            $rc ->bindParam(':cmail',$cmail);
            $rc ->bindParam(':cperson',$cperson);
            $rc ->bindParam(':contphone',$contphon);
            $rc ->bindParam(':cloc',$cloc);
            $rc ->bindParam(':cbank_acc',$cbank_acc);
            $rc ->bindParam(':cbank',$cbank);
            $rc ->bindParam(':compid',$compid);
            $rc ->execute();

            if($rc){
                Yii::$app->session->setFlash('success-createc','Company Info Updated Successfully');
                return $this->redirect(['comp-profile']);
            }else{
                Yii::$app->session->setFlash('failed-createc','Details where not Updated. Please Contact Administrator');
                return $this->redirect(['comp-profile']);
            }
        }
        return $this->renderAjax('upd_comp',[
            'modProfile'=>$modProfile,
        ]);
    }

    public function actionNoaccess()
    {
        return $this->render('noaccess');
    }

    public function actionPosition()
    {
        $modPos = new Positions();
        $tbPos = $this->getpositions();

        if(isset($_POST['btnpos']))
        {
            $modPos->load(Yii::$app->request->post());
            $pos = $modPos->pos_name;

            $cr = Yii::$app->db->createCommand("insert into positions(pos_name)values(:pos)")->bindParam(':pos',$pos)->execute();
            if($cr)
            {
                Yii::$app->session->setFlash('success-crpos','Position Added Successfully');
                return $this->redirect(['position']);
            }
        }

        return $this->render('position',[
            'modPos'=>$modPos,'tbPos'=>$tbPos
        ]);
    }

    protected function getpositions()
    {
        $getPemethod = Yii::$app->db->createCommand("select posid,pos_name from positions order by posid asc")->queryAll(0);
        $tbP = "<table id='example1' class='table table-striped table-bordered'>";
        $tbP .="<thead><tr><th>SN</th><th>Position Name</th><th>Action</th></tr></thead><tbody>";
        $i=1;
        foreach ($getPemethod as $p)
        {
            $tbP .= "<tr><td>$i</td><td>$p[1]</td><td><b>" . Html::a('<i class="fa fa-trash-alt"></i> Remove', ['users/rmpos','pid'=>$p[0]],['class'=>'btn btn-warning btn-sm','onClick'=>'return confirm(" Are you sure you want to remove this")']) . "</b></td></tr>";
            $i++;
        }
        $tbP .="</tbody></table>";

        return $tbP;
    }

    public function actionRmpos($pid)
    {
        $remove = Yii::$app->db->createCommand("delete from positions where posid = :pid")->bindParam(':pid',$pid)->execute();

        Yii::$app->session->setFlash('success-rmpos','Position Removed Successfully');
        return $this->redirect(['pay-methods']);

    }
}
