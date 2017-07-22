<?php

namespace frontend\controllers;

use Yii;
use common\models\FlowOrder;
use common\models\FlowOrderSearch;
use common\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FlowOrderController implements the CRUD actions for FlowOrder model.
 */
class FlowOrderController extends Controller
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
     * Lists all FlowOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlowOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FlowOrder model.
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
     * Creates a new FlowOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FlowOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateAuto()
    {
        $model = new FlowOrder();
        $data['orderNumber'] = FlowOrder::generateNewOrderNumber();
        $data['supplierList'] = Product::getAllSupplier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create-auto', [
                'model' => $model,
                'data' => $data,
            ]);
        }
    }

    /**
     * Updates an existing FlowOrder model.
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
     * Deletes an existing FlowOrder model.
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
     * Finds the FlowOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlowOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlowOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSaveBill()
    {
        $datas = Yii::$app->request->post();
        $orderNumber = $datas['orderNumber'];
        $productSuppliers = $datas['supplier'];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        foreach ($datas as $k => $v) {
            if (stripos($k, 'bill_number_')!==false) {
                $id = str_ireplace('bill_number_', '', $k);
                $model = new FlowOrder();
                $model->order_number = $orderNumber;
                $model->product_suppliers = $productSuppliers;
                $model->created_at = date("Y-m-d H:i:s", time());
                foreach ($datas as $k2 => $v2) {
                    if (stripos($k2, '_'.$id)!==false) {
                        $key = str_ireplace('_'.$id, '', $k2);
                        $model->$key = $v2;
                    }
                }
                if ($model->save()) {

                } else {
                    throw new \yii\base\Exception('保存数据失败。'.json_encode($model->getErrors()));
                }
            }
        }
        return [
            'success' => true,
            'redirect' => '/flow-order/index?sort=-id',
        ];
    }
}
