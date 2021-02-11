<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
            $this->redirect(['site/login']);
        }else{
            $con = Yii::$app->db;
            $query = "select d.debtor_code,d.debtor_name,s.invoice_no,total_litres,total_sale,s.status,d.debtor_id,
                case s.status when 'C' then 'Invoice Created' when 'I' then 'Partial Payment' when 'P' then 'Paid' end bill_status
                from debtor_sales s
                inner join debtors d on d.debtor_id=s.debtor_id order by s.crdate desc limit 10";
            $orders = $con->createCommand($query)->queryAll(0);

            $stations = $con->createCommand("select count(*) from shells")->queryScalar();
            $pumps = $con->createCommand("select count(*) from pumps")->queryScalar();
            $debtors = $con->createCommand("select count(*) from debtors")->queryScalar();
            $sales = $con->createCommand("select sum(sales) from (
            select sum(total_sell) sales from station_sells union select sum(paid_amount) sales from debtor_sales) s")->queryScalar();

            return $this->render('index',[
                'orders'=>$orders, 'stations'=>$stations,'pumps'=>$pumps,
                'debtors'=>$debtors,'sales'=>$sales
            ]);
        }

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $this->layout = 'main-login';
        $model = new LoginForm();

        if(isset($_POST['reqpass']))
        {
            $model->load(Yii::$app->request->post());
            $mail = $model->username;

            $r = "select count(*) from tbl_user where email = :mail";
            $exist = Yii::$app->db->createCommand($r)->queryScalar();

            if($exist < 1)
            {
                Yii::$app->session->setFlash("Email provided Doesn't exist. Please make sure you provide correct Email");
            }
            if($exist > 0)
            {
                $message = '<div class="site-index">';
                $message .= '<h5>Hello '. $mail[0].',</h5>';
                $message .= '<p>Please click the link to resert you Password <strong>'.$yesterday .'</strong>.</p>';
                $message .= '<p>Thank you, <br>';
                $message .= '<p>Stroils Petroleum</p><br>' ;
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
            }
        }
        return $this->render('forgot_password',[
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
