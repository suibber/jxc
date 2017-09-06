<?php

namespace frontend\controllers;

use Yii;
use common\models\FlowIn;
use common\models\FlowOut;
use common\models\FlowInSearch;
use common\models\Product;
use frontend\controllers\Base;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * FlowInController implements the CRUD actions for FlowIn model.
 */
class FlowInController extends Base
{
    /**
     * Lists all FlowIn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlowInSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStore()
    {
        $query = FlowIn::find()
            ->select("in_store,type,model,sum(quantity) quantity,sum(in_price) in_price")
            ->groupBy("in_store,type,model");

        $in_store = Yii::$app->request->get('in_store');
        $type = Yii::$app->request->get('type');
        $model = Yii::$app->request->get('model');
        if ($in_store) {
            $query = $query->andWhere(['like', 'in_store', $in_store]);
        }
        if ($type) {
            $query = $query->andWhere(['like', 'type', $type]);
        }
        if ($model) {
            $query = $query->andWhere(['like', 'model', $model]);
        }

        // 计算sum - start
        $listAll = $query
            ->limit(1000)
            ->asArray()->all();
        $countQuantity = 0;
        $countPrice = 0.00;
        foreach ($listAll as $key => $item) {
            $outInfo = FlowOut::find()
                ->select("sum(quantity) quantity,sum(in_price) in_price")
                ->where([
                    'out_store' => $item['in_store'],
                    'type' => $item['type'],
                    'model' => $item['model'],
                ])
                ->groupBy("out_store,type,model")
                ->asArray()
                ->one();
            $storeQuantity = 0;
            $storePrice = 0;
            $outQuantity = 0;
            $outPrice = 0.00;
            if ($outInfo) { 
                $outQuantity = $outInfo['quantity'];
                $outPrice = $outInfo['in_price'];
            }
            $storeQuantity = $item['quantity'] - $outQuantity;
            $storePrice = $item['in_price'] - $outPrice;
            $countQuantity += $storeQuantity;
            $countPrice += $storePrice;
        } 
        // 计算sum - end

        $count = $query->count();
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $count]);

        $list = $query->offset($pages->offset)
            ->limit($pages->limit)->asArray()->all();

        foreach ($list as $key => $item) {
            $outInfo = FlowOut::find()
                ->select("sum(quantity) quantity,sum(in_price) in_price")
                ->where([
                    'out_store' => $item['in_store'],
                    'type' => $item['type'],
                    'model' => $item['model'],
                ])
                ->groupBy("out_store,type,model")
                ->asArray()
                ->one();
            $list[$key]['out_quantity'] = 0;
            $list[$key]['out_price'] = 0;
            if ($outInfo) { 
                $list[$key]['out_quantity'] = $outInfo['quantity'];
                $list[$key]['out_price'] = $outInfo['in_price'];
            }
        } 

        return $this->render('store', [
            'list' => $list,
            'pages' => $pages,
            'count' => $count,
            'countQuantity' => $countQuantity,
            'countPrice' => $countPrice,
        ]);
    }

    /**
     * Displays a single FlowIn model.
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
     * Creates a new FlowIn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FlowIn();

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
        $model = new FlowIn();
        $data['orderNumber'] = FlowIn::generateNewInNumber();
        $data['supplierList'] = Product::getAllSupplier();
        $data['storeList'] = Yii::$app->params['storeList'];

        return $this->render('create-auto', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * Updates an existing FlowIn model.
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
     * Deletes an existing FlowIn model.
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
     * Finds the FlowIn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlowIn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlowIn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSaveBill()
    {
        $datas = Yii::$app->request->post();
        $orderNumber = $datas['orderNumber'];
        $inNumber = $datas['inNumber'];
        $inStore = $datas['inStore'];
        $productSuppliers = $datas['supplier'];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        foreach ($datas as $k => $v) {
            if (stripos($k, 'bill_number_')!==false) {
                $id = str_ireplace('bill_number_', '', $k);
                $model = new FlowIn();
                $model->in_number = $inNumber;
                $model->order_number = $orderNumber;
                $model->product_suppliers = $productSuppliers;
                $model->product_suppliers_short = mb_substr($productSuppliers, 0, 13, 'utf-8');
                $model->in_store = $inStore;
                $model->created_at = date("Y-m-d H:i:s", time());
                foreach ($datas as $k2 => $v2) {
                    $number = array_pop(explode("_", $k2));
                    if ($number == $id) {
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
            'redirect' => '/flow-in/index?sort=-id',
        ];
    }

    public function actionPreviewBill()
    {
        $datas = Yii::$app->request->post();
        $orderNumber = $datas['orderNumber'];
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

    public function actionGetInInfo()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $lotNumber = Yii::$app->request->post('lot_number');
        $model = Yii::$app->request->post('model');
        $info = FlowIn::find()
            ->where(['lot_number' => $lotNumber])
            ->andWhere(['like', 'model', $model])
            ->one();
        if (!$info) {
            $info = Product::find()
                ->where(['like', 'model', $model])
                ->asArray()
                ->one();
            $info['in_one_price'] = $info['price'];
            $info['product_name'] = $info['name'];
        }
        return [
            'success' => true,
            'data' => $info,
        ];
    }
}
