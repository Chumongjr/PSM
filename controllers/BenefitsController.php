<?php

namespace app\controllers;

use Yii;
use app\models\Benefits;
use app\models\Deductions;
use app\models\Loans;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BenefitsController implements the CRUD actions for Benefits model.
 */
class BenefitsController extends Controller
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
     * Lists all Benefits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modBen = new Benefits();
        $benlist = $modBen::benlist();

        return $this->render('index', [
            'benlist' => $benlist,
        ]);
    }

    public function actionDedlist()
    {
        $modDed = new Deductions();
        $dedlist = $modDed::dedlist();

        return $this->render('deducts', [
            'dedlist' => $dedlist,
        ]);
    }

    public function actionNdeduction()
    {
        $modelded = new Deductions();
        $isupdt = false;

        if (isset($_POST['btnRegded'])) {
            $modelded->load(Yii::$app->request->post());
            $dname = $modelded->ded_name;
            $isper = $modelded->is_percentage;
            if($isper == 0){ $isp = 'N';}else{$isp = 'Y';}
            $employeeper = $modelded->employee_perc;
            $employerper = $modelded->employer_perc;
            $famt = $modelded->fixed_amount;
            //echo $isp; exit;
            $rs = "insert into deductions(ded_name,is_percentage,employee_perc,employer_perc,fixed_amount) values(:bname,:isper,:employeeper,:employerper,:famt)";
            $dinsert = Yii::$app->db->createCommand($rs);
            $dinsert ->bindParam(':bname',$dname);
            $dinsert ->bindParam(':isper',$isp);
            $dinsert ->bindParam(':employeeper',$employeeper);
            $dinsert ->bindParam(':employerper',$employerper);
            $dinsert ->bindParam(':famt',$famt);
            $dinsert->execute();

            if($dinsert){
                Yii::$app->session->setFlash('success-createded','New Deduction Created Successfull');
                return $this->redirect(['dedlist']);
            }else{
                Yii::$app->session->setFlash('failed-createded','Deduction was not created. Please Contact Administrator');
                return $this->redirect(['dedlist']);
            }
        }
        return $this->renderAjax('newdedt',[
            'modelded'=>$modelded,'isupdt'=>$isupdt
        ]);
    }

    public function actionDedupdate($dedid)
    {
        $modelded = $this->findModeldedct($dedid);
        $isupdt = true;
        if (isset($_POST['btnUpdtded'])) {
            $modelded->load(Yii::$app->request->post());
            $dname = $modelded->ded_name;
            $isper = $modelded->is_percentage;
            if($isper == 0){ $isp = 'N';}else{$isp = 'Y';}
            $employeeper = $modelded->employee_perc;
            $employerper = $modelded->employer_perc;
            $famt = $modelded->fixed_amount;
            //echo $isp; exit;
            $rs = "update deductions set ded_name=:bname,is_percentage=:isper,employee_perc=:employeeper,employer_perc=:employerper,fixed_amount=:famt where  dedid = $dedid";
            $dinsert = Yii::$app->db->createCommand($rs);
            $dinsert ->bindParam(':bname',$dname);
            $dinsert ->bindParam(':isper',$isp);
            $dinsert ->bindParam(':employeeper',$employeeper);
            $dinsert ->bindParam(':employerper',$employerper);
            $dinsert ->bindParam(':famt',$famt);
            $dinsert->execute();

            if($dinsert){
                Yii::$app->session->setFlash('success-createded','Deduction Update Successfull');
                return $this->redirect(['dedlist']);
            }else{
                Yii::$app->session->setFlash('failed-createded','Deduction was not update. Please Contact Administrator');
                return $this->redirect(['dedlist']);
            }
        }
        return $this->renderAjax('newdedt',[
            'modelded'=>$modelded,'isupdt'=>$isupdt,
        ]);
    }

    public function actionLoanlist()
    {
        $modLoan = new Loans();
        $loanlist = $modLoan::loanlist();

        return $this->render('loanlist',[
            'modloan'=>$modLoan,'loanlist'=>$loanlist
        ]);
    }

    public function actionNloan()
    {
        $modloan = new Loans();
        $isupdt = false;

        if (isset($_POST['btnRegloan'])) {
            $modloan->load(Yii::$app->request->post());
            $lname = $modloan->loan_name;
            $intper = $modloan->interest;
            $payperiod = $modloan->payperiod;

            $rs = "insert into loans(loan_name,payperiod,interest) values(:lname,:intper,:payperiod)";
            $dinsert = Yii::$app->db->createCommand($rs);
            $dinsert ->bindParam(':lname',$lname);
            $dinsert ->bindParam(':payperiod',$payperiod);
            $dinsert ->bindParam(':intper',$intper);
            $dinsert->execute();

            if($dinsert){
                Yii::$app->session->setFlash('success-createloan','New Loan Created Successfull');
                return $this->redirect(['loanlist']);
            }else{
                Yii::$app->session->setFlash('failed-createloan','Loan was not created. Please Contact Administrator');
                return $this->redirect(['loanlist']);
            }
        }
        return $this->renderAjax('newloan',[
            'modloan'=>$modloan,'isupdt'=>$isupdt
        ]);
    }

    public function actionLoanupd($lid)
    {
        $modloan = $this->findModelloan($lid);
        $isupdt = true;

        if (isset($_POST['btnUpdtloan'])) {
            $modloan->load(Yii::$app->request->post());
            $lname = $modloan->loan_name;
            $intper = $modloan->interest;
            $payperiod = $modloan->payperiod;

            $rs = "update loans set loan_name=:lname,payperiod=:payperiod,interest=:intper where  loanid = $lid";
            $dinsert = Yii::$app->db->createCommand($rs);
            $dinsert ->bindParam(':lname',$lname);
            $dinsert ->bindParam(':payperiod',$payperiod);
            $dinsert ->bindParam(':intper',$intper);
            $dinsert->execute();

            if($dinsert){
                Yii::$app->session->setFlash('success-createloan','Loan Update Successfull');
                return $this->redirect(['loanlist']);
            }else{
                Yii::$app->session->setFlash('failed-createloan','Loan was not update. Please Contact Administrator');
                return $this->redirect(['loanlist']);
            }
        }

        return $this->renderAjax('newloan',[
            'modloan'=>$modloan,'isupdt'=>$isupdt,
        ]);
    }

    /**
     * Displays a single Benefits model.
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
     * Creates a new Benefits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Benefits();
        $isupdt = false;

        if (isset($_POST['btnRegben'])) {
            $model->load(Yii::$app->request->post());
            $bname = $model->ben_name;
            $isper = $model->is_percentage;
            if($isper == 0){ $isp = 'N';}else{$isp = 'Y';}
            $per = $model->percentage;
            $famt = $model->fixed_amount;
            //echo $isp; exit;
            $rs = "insert into benefits(ben_name,is_percentage,percentage,fixed_amount) values(:bname,:isper,:per,:famt)";
            $binsert = Yii::$app->db->createCommand($rs);
            $binsert ->bindParam(':bname',$bname);
            $binsert ->bindParam(':isper',$isp);
            $binsert ->bindParam(':per',$per);
            $binsert ->bindParam(':famt',$famt);
            $binsert->execute();

            if($binsert){
                Yii::$app->session->setFlash('success-createben','New Benefit Created Successfull');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('failed-createben','Benefit was not created. Please Contact Administrator');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,'isupdt'=>$isupdt
        ]);
    }

    /**
     * Updates an existing Benefits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($bid)
    {
        $isupdt = true;
        $model = $this->findModel($bid);

        if (isset($_POST['btnUpdtben'])) {
            $model->load(Yii::$app->request->post());
            $bname = $model->ben_name;
            $isper = $model->is_percentage;
            if($isper == 0){ $isp = 'N';}else{$isp = 'Y';}
            $per = $model->percentage;
            $famt = $model->fixed_amount;
            //echo $bid; exit;
            $rs = "update benefits set ben_name = :bname,is_percentage=:isper,percentage=:per,fixed_amount=:famt where benid=:bid";
            $binsert = Yii::$app->db->createCommand($rs);
            $binsert ->bindParam(':bname',$bname);
            $binsert ->bindParam(':isper',$isp);
            $binsert ->bindParam(':per',$per);
            $binsert ->bindParam(':famt',$famt);
            $binsert ->bindParam(':bid',$bid);
            $binsert->execute();

            if($binsert){
                Yii::$app->session->setFlash('success-createben','Benefit Updated Successfull');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('failed-createben','Benefit was not Updated. Please Contact Administrator');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,'isupdt'=>$isupdt
        ]);
    }

    /**
     * Deletes an existing Benefits model.
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
     * Finds the Benefits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Benefits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Benefits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModeldedct($dedid)
    {
        if (($model = Deductions::findOne($dedid)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelloan($lid)
    {
        if (($model = Loans::findOne($lid)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
