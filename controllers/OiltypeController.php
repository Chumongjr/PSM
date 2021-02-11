<?php

namespace app\controllers;

use Yii;
use app\models\Oiltype;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * OiltypeController implements the CRUD actions for Oiltype model.
 */
class OiltypeController extends Controller
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
     * Lists all Oiltype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Oiltype();
        $op="select type_id,oil_type,cur_price as price from oil_type";

        $dataProvider = new SqlDataProvider([
            'sql' => $op,
            'key' => 'type_id',
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('_list', [
            'model'=>$model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChangeprice($id)
    {
        $model = new Oiltype();
        $eid = Yii::$app->user->id;
        $edate = date('Y-m-d');

        $model->load(Yii::$app->request->post());
        $price = $model->cur_price;

        $upd=Yii::$app->db->createCommand("update oil_type set cur_price='$price',edited_by='$eid',edited_date = '$edate' where type_id = '$id'")->execute();

        return $this->redirect(['oiltype/index']);
    }

    /**
     * Displays a single Oiltype model.
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
     * Creates a new Oiltype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Oiltype();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->type_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Oiltype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->type_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Oiltype model.
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
     * Finds the Oiltype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Oiltype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Oiltype::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
