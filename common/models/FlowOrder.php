<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flow_order".
 *
 * @property integer $id
 * @property string $number
 * @property string $order_number
 * @property string $bill_number
 * @property string $model
 * @property integer $quantity
 * @property string $discount
 * @property string $discount_price
 * @property string $order_price
 * @property string $comment
 * @property string $product_price
 * @property string $product_suppliers
 * @property string $product_name
 * @property string $operator
 * @property string $created_at
 * @property string $updated_at
 */
class FlowOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flow_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'discount_price', 'order_price', 'product_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['number', 'order_number', 'bill_number', 'model', 'operator'], 'string', 'max' => 100],
            [['discount'], 'string', 'max' => 20],
            [['comment', 'product_suppliers', 'product_name'], 'string', 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '订单序号',
            'order_number' => '订单号',
            'bill_number' => '单据序号',
            'model' => '产品型号',
            'quantity' => '数量',
            'discount' => '折扣',
            'discount_price' => '折扣单价',
            'order_price' => '订单金额',
            'comment' => '备注',
            'product_price' => '标准单价',
            'product_suppliers' => '供应商',
            'product_name' => '产品名称',
            'operator' => 'Operator',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return FlowOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FlowOrderQuery(get_called_class());
    }

    public static function generateNewOrderNumber()
    {
        $latestOrder = FlowOrder::find()
            ->orderBy('id', SORT_DESC)
            ->one();
        $latestNumber = isset($latestOrder->order_number) ? $latestOrder->order_number : '';
        $list = explode('-', $latestNumber);
        $order = isset($list[2]) ? ($list[2]+1) : 1;
        return 'Order-'.date("Ymd", time()).'-'.$order;
    }
}
