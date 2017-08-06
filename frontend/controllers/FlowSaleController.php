<?php

namespace frontend\controllers;

use Yii;
use common\models\FlowSale;
use common\models\FlowSaleSearch;
use common\models\Customer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

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

    public function actionPreviewBill()
    {
        $datas = Yii::$app->request->post();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $list = [];
        foreach ($datas as $k => $v) {
            if (stripos($k, 'bill_number_')!==false) {
                $id = str_ireplace('bill_number_', '', $k);
                foreach ($datas as $k2 => $v2) {
                    if (stripos($k2, '_'.$id)!==false) {
                        $key = str_ireplace('_'.$id, '', $k2);
                        $list[$k][$key] = $v2;
                    }
                }
            }
        }
        $view = $this->renderPartial('preview', [
            'datas' => $datas,
            'list' => $list,
        ]);
        $cacheKey = MD5($view);
        Yii::$app->cache->set($cacheKey, $view);
        return [
            'success' => true,
            'redirect' => '/flow-order/preview-bill-real?key='.$cacheKey,
        ];
    }

    public function actionStore()
    {
        $query = FlowSale::find()
            ->select("sale_number,custom,sum(quantity) quantity,sum(sale_price) sale_price,salesman,bill_number2,bill_price,bill_status,reture_price,return_time,return_status")
            ->groupBy("sale_number");

        $sale_number = Yii::$app->request->get('in_store');
        $custom = Yii::$app->request->get('type');
        if ($sale_number) {
            $query = $query->andWhere(['like', 'sale_number', $sale_number]);
        }
        if ($custom) {
            $query = $query->andWhere(['like', 'custom', $custom]);
        }

        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $query->count()]);

        $list = $query->offset($pages->offset)
            ->limit($pages->limit)->asArray()->all();

        return $this->render('store', [
            'list' => $list,
            'pages' => $pages,
        ]);
    }

    public function actionSetBill()
    {
        $data['bill_number2'] = Yii::$app->request->post('bill_number2');
        $data['bill_price'] = Yii::$app->request->post('bill_price');
        $data['bill_status'] = Yii::$app->request->post('bill_status');
        $data['reture_price'] = Yii::$app->request->post('reture_price');
        $data['return_time'] = Yii::$app->request->post('return_time');
        $data['return_status'] = Yii::$app->request->post('return_status');
        $sale_number = Yii::$app->request->post('sale_number');
        FlowSale::updateAll($data, ['sale_number' => $sale_number]);
    }
}
