<?php

namespace frontend\controllers;

use Yii;
use common\models\FlowOut;
use common\models\FlowIn;
use common\models\FlowSale;
use common\models\FlowOutSearch;
use common\models\SalePrice;
use frontend\controllers\Base;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * FlowOutController implements the CRUD actions for FlowOut model.
 */
class FlowOutController extends Base
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
     * Lists all FlowOut models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlowOutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FlowOut model.
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
     * Creates a new FlowOut model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FlowOut();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FlowOut model.
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
     * Deletes an existing FlowOut model.
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
     * Finds the FlowOut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlowOut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlowOut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateAuto()
    {
        $model = new FlowOut();
        $data['orderNumber'] = FlowOut::generateNewInNumber();
        $data['supplierList'] = SalePrice::getAllSales();
        $data['storeList'] = Yii::$app->params['storeList'];

        return $this->render('create-auto', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionSaveBill()
    {
        $datas = Yii::$app->request->post();
        $outNumber = $datas['outNumber'];
        $outStore = $datas['outStore'];
        $receiver = $datas['supplier'];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        foreach ($datas as $k => $v) {
            if (stripos($k, 'bill_number_')!==false) {
                $id = str_ireplace('bill_number_', '', $k);
                $model = new FlowOut();
                $model->out_number = $outNumber;
                $model->receiver = $receiver;
                $model->receiver_short = mb_substr($receiver, 0, 13, 'utf-8');
                $model->out_store = $outStore;
                $model->created_at = date("Y-m-d H:i:s", time());
                foreach ($datas as $k2 => $v2) {
                    $number = array_pop(explode("_", $k2));
                    if ($number == $id) {
                    //if (stripos($k2, '_'.$id)!==false) {
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
            'redirect' => '/flow-out/index?sort=-id',
        ];
    }

    public function actionPreviewBill()
    {
        $datas = Yii::$app->request->post();
        $orderNumber = $datas['outNumber'];
        $productSuppliers = $datas['supplier'];
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
        $query = FlowOut::find()
            ->select("receiver,receiver_short,type,model,sum(quantity) quantity,sum(in_price) in_price")
            ->orderBy(["type" => SORT_DESC])
            ->groupBy("receiver_short,type,model");

        $receiver = Yii::$app->request->get('receiver');
        $type = Yii::$app->request->get('type');
        $model = Yii::$app->request->get('model');
        $model = str_ireplace("  ", " +", $model);
        if ($receiver) {
            $query = $query->andWhere(['like', 'receiver', $receiver]);
        }
        if ($type) {
            $query = $query->andWhere(['like', 'type', $type]);
        }
        if ($model) {
            $query = $query->andWhere(['like', 'model', $model]);
        }

        // 计算sum - start
        $countLimit = Yii::$app->params["countLimit"];
        $listAll = $query
            ->limit($countLimit)
            ->asArray()->all();
        $count_quantity = 0;
        $count_in_price = 0.00;
        $count_inin_quantity = 0;
        $count_inin_price = 0.00;
        $count_sale_quantity = 0;
        $count_sale_price = 0.00;
        foreach ($listAll as $key => $item) {


            $outInfo = FlowIn::find()
                ->select("sum(quantity) quantity,sum(in_price) in_price")
                ->where([
                    'product_suppliers' => $item['receiver'],
                    'type' => $item['type'],
                    'model' => $item['model'],
                ])
                ->groupBy("product_suppliers,type,model")
                ->asArray()
                ->one();
            if ($outInfo) { 
                $count_inin_quantity += $outInfo['quantity'];
                $count_inin_price += $outInfo['in_price'];
            }
            $saleInfo = FlowSale::find()
                ->select("sum(quantity) quantity,sum(sale_price) in_price")
                ->where([
                    'custom' => $item['receiver'],
                    'model' => $item['model'],
                ])
                ->groupBy("custom,model")
                ->asArray()
                ->one();
            if ($saleInfo) { 
                $count_sale_quantity += $saleInfo['quantity'];
                $count_sale_price += $saleInfo['in_price'];
            }

            $count_quantity += $item['quantity'];
            $count_in_price += $item['in_price'];
        } 
        // 计算sum - end

        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $query->count()]);

        $list = $query->offset($pages->offset)
            ->limit($pages->limit)->asArray()->all();

        foreach ($list as $key => $item) {
            $outInfo = FlowIn::find()
                ->select("sum(quantity) quantity,sum(in_price) in_price")
                ->where([
                    'product_suppliers' => $item['receiver'],
                    'type' => $item['type'],
                    'model' => $item['model'],
                ])
                ->groupBy("product_suppliers,type,model")
                ->asArray()
                ->one();
            $list[$key]['inin_quantity'] = 0;
            $list[$key]['inin_price'] = 0;
            if ($outInfo) { 
                $list[$key]['inin_quantity'] = $outInfo['quantity'];
                $list[$key]['inin_price'] = $outInfo['in_price'];
            }
            $saleInfo = FlowSale::find()
                ->select("sum(quantity) quantity,sum(sale_price) in_price")
                ->where([
                    'custom' => $item['receiver'],
                    'model' => $item['model'],
                ])
                ->groupBy("custom,model")
                ->asArray()
                ->one();
            $list[$key]['sale_quantity'] = 0;
            $list[$key]['sale_price'] = 0;
            if ($saleInfo) { 
                $list[$key]['sale_quantity'] = $saleInfo['quantity'];
                $list[$key]['sale_price'] = $saleInfo['in_price'];
            }
        } 

        return $this->render('store', [
            'list' => $list,
            'pages' => $pages,
            'count_quantity' => $count_quantity,
            'count_in_price' => sprintf("%.2f", $count_in_price),
            'count_inin_quantity' => $count_inin_quantity,
            'count_inin_price' => sprintf("%.2f", $count_inin_price),
            'count_sale_quantity' => $count_sale_quantity,
            'count_sale_price' => sprintf("%.2f", $count_sale_price),
        ]);
    }
}
