<?php

namespace frontend\controllers;

use Yii;
use common\models\FlowOrder;
use common\models\FlowOrderSearch;
use common\models\Product;
use common\models\FlowIn;
use frontend\controllers\Base;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\data\Pagination;

/**
 * FlowOrderController implements the CRUD actions for FlowOrder model.
 */
class FlowOrderController extends Base
{
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
                    throw new Exception('保存数据失败。'
                        .json_encode($model->getErrors()));
                }
            }
        }
        return [
            'success' => true,
            'redirect' => '/flow-order/index?sort=-id',
        ];
    }

    public function actionGetOrderInfo()
    {
        $orderNumber = Yii::$app->request->post('order_number');
        $model = Yii::$app->request->post('model');
        $orderInfo = FlowOrder::getOrderInfoByOrderNumber($orderNumber, $model);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'data' => $orderInfo,
        ];
    }

    public function actionStore()
    {
        $query = FlowOrder::find()
            ->select("order_number,sum(quantity) quantity,sum(order_price) order_price,pay_percent,pay_price,pay_price_not,pay_time,pay_status,bill_number2,bill_price,bill_time,bill_status,arrival_status,detail_comment,product_suppliers")
            ->groupBy("order_number");

        $in_store = Yii::$app->request->get('in_store');
        $type = Yii::$app->request->get('type');
        $model = Yii::$app->request->get('model');
        if ($in_store) {
            $query = $query->andWhere(['like', 'order_number', $in_store]);
        }
        if ($type) {
            $query = $query->andWhere(['like', 'product_suppliers', $type]);
        }

        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $query->count()]);

        $list = $query->offset($pages->offset)
            ->limit($pages->limit)->asArray()->all();

        foreach ($list as $key => $item) {
            $outInfo = FlowIn::find()
                ->select("sum(quantity) quantity,sum(in_price) in_price")
                ->where([
                    'order_number' => $item['order_number'],
                ])
                ->groupBy("number")
                ->asArray()
                ->one();
            $list[$key]['in_quantity'] = 0;
            $list[$key]['in_price'] = 0;
            if ($outInfo) { 
                $list[$key]['in_quantity'] = $outInfo['quantity'];
                $list[$key]['in_price'] = $outInfo['in_price'];
            }
            $arrival_status = '';
            if ($list[$key]['in_quantity']==$list[$key]['quantity']) {
                $arrival_status = '全部到货';
            } else if (!$list[$key]['in_quantity']) {
                $arrival_status = '未到货';
            } else {
                $arrival_status = '部分到货';
            }
            FlowOrder::updateAll(['arrival_status' => $arrival_status], ['order_number' => $item['order_number']]);
        }

        return $this->render('store', [
            'list' => $list,
            'pages' => $pages,
        ]);
    }

    public function actionSetPercent()
    {
        $data['pay_percent'] = Yii::$app->request->post('pay_percent');
        $data['pay_price'] = Yii::$app->request->post('pay_price');
        $data['pay_price_not'] = Yii::$app->request->post('pay_price_not');
        $data['pay_status'] = Yii::$app->request->post('pay_status');
        $data['pay_time'] = date("Y-m-d H:i:s", time());
        $order_id = Yii::$app->request->post('order_id');
        FlowOrder::updateAll($data, ['order_number' => $order_id]);
    }

    public function actionSetBill()
    {
        $data['bill_number2'] = Yii::$app->request->post('bill_number2');
        $data['bill_price'] = Yii::$app->request->post('bill_price');
        $data['bill_status'] = Yii::$app->request->post('bill_status');
        $data['bill_time'] = Yii::$app->request->post('bill_time');
        $order_id = Yii::$app->request->post('order_id');
        FlowOrder::updateAll($data, ['order_number' => $order_id]);
    }
}
