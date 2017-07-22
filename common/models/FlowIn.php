<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flow_in".
 *
 * @property integer $id
 * @property string $number
 * @property string $in_number
 * @property string $bill_number
 * @property string $order_number
 * @property string $in_store
 * @property string $code_one
 * @property string $code_two
 * @property string $lot_number
 * @property string $expiration_date_one
 * @property string $expiration_date_two
 * @property string $model
 * @property integer $quantity
 * @property string $in_one_price
 * @property string $in_price
 * @property string $comment
 * @property string $product_suppliers
 * @property string $product_suppliers_short
 * @property string $product_name
 * @property string $type
 * @property string $operator
 * @property string $created_at
 * @property string $updated_at
 */
class FlowIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flow_in';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity'], 'integer'],
            [['in_one_price', 'in_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['number', 'in_number', 'bill_number', 'order_number', 'in_store', 'code_one', 'code_two', 'expiration_date_one', 'expiration_date_two', 'model', 'type', 'operator'], 'string', 'max' => 100],
            [['lot_number', 'product_suppliers_short'], 'string', 'max' => 200],
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
            'number' => '入库序号',
            'in_number' => '入库单号',
            'bill_number' => '单据序号',
            'order_number' => '订单/出库单号',
            'in_store' => '入库库房',
            'code_one' => '条形码1',
            'code_two' => '条形码2',
            'lot_number' => '批号',
            'expiration_date_one' => '有效期1',
            'expiration_date_two' => '有效期2',
            'model' => '产品型号',
            'quantity' => '数量',
            'in_one_price' => '进货单价',
            'in_price' => '进货金额',
            'comment' => '备注',
            'product_suppliers' => '供应商',
            'product_suppliers_short' => '供应商简写',
            'product_name' => '产品名称',
            'type' => '分类',
            'operator' => 'Operator',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return FlowInQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FlowInQuery(get_called_class());
    }

    public static function generateNewInNumber()
    {
        $latestOrder = FlowIn::find()
            ->orderBy('id', SORT_DESC)
            ->one();
        $latestNumber = isset($latestOrder->order_number) ? $latestOrder->order_number : '';
        $list = explode('-', $latestNumber);
        $order = isset($list[2]) ? ($list[2]+1) : 1;
        return 'In-'.date("Ymd", time()).'-'.$order;
    }
}
