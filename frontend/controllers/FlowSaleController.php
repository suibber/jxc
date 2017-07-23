<?php

namespace frontend\controllers;

use Yii;
use common\models\FlowSale;
use common\models\FlowSaleSearch;
use common\models\Customer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FlowSaleController implements the CRUD actions for FlowSale model.
 */
class FlowSaleController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all FlowSale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlowSaleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FlowSale model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FlowSale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FlowSale();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FlowSale model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FlowSale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FlowSale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlowSale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlowSale::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateAuto()
    {
        $model = new FlowSale();
        $data['orderNumber'] = FlowSale::generateNewInNumber();
        $data['supplierList'] = Customer::getAllCustomers();
        $data['storeList'] = Yii::$app->params['storeList'];

        return $this->render('create-auto', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionSaveBill()
    {
        $datas = Yii::$app->request->post();
        $saleNumber = $datas['saleNumber'];
        $custom = $datas['custom'];
        $salesman = $datas['salesman'];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        foreach ($datas as $k => $v) {
            if (stripos($k, 'bill_number_')!==false) {
                $id = str_ireplace('bill_number_', '', $k);
                $model = new FlowSale();
                $model->sale_number = $saleNumber;
                $model->custom = $custom;
                $model->custom_short = mb_substr($custom, 0, 13, 'utf-8');
                $model->salesman = $salesman;
                $model->created_at = date("Y-m-d H:i:s", time());
                foreach ($datas as $k2 => $v2) {
                    if (stripos($k2, '_'.$id)!==false) {
                        $key = str_ireplace('_'.$id, '', $k2);
                        $model->$key = $v2;
                    }
                }
                if ($model->save()) {

                } else {
                    throw new Exception('保存数据失败。'
                        .json_encode($model->getErrors()));
                }
            }
        }
        return [
            'success' => true,
            'redirect' => '/flow-sale/index?sort=-id',
        ];
    }
}
