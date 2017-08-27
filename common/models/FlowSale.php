<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flow_sale".
 *
 * @property integer $id
 * @property string $number
 * @property string $sale_number
 * @property string $bill_number
 * @property string $model
 * @property integer $quantity
 * @property string $in_one_price
 * @property string $in_price
 * @property string $sale_one_price
 * @property string $sale_price
 * @property string $comment
 * @property string $custom
 * @property string $custom_short
 * @property string $salesman
 * @property string $product_name
 * @property string $operator
 * @property string $created_at
 * @property string $updated_at
 */
class FlowSale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flow_sale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity'], 'integer'],
            [['in_one_price', 'in_price', 'sale_one_price', 'sale_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['number', 'sale_number', 'bill_number', 'model', 'operator'], 'string', 'max' => 100],
            [['comment', 'custom', 'product_name'], 'string', 'max' => 400],
            [['custom_short', 'salesman'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '销售序号',
            'sale_number' => '销售单号',
            'bill_number' => '销售序号',
            'model' => '产品型号',
            'quantity' => '数量',
            'in_one_price' => '进货单价',
            'in_price' => '进货金额',
            'sale_one_price' => '销售单价',
            'sale_price' => '销售金额',
            'comment' => '备注',
            'custom' => '客户名称',
            'custom_short' => '客户名称简写',
            'salesman' => '销售人员',
            'product_name' => '产品名称',
            'operator' => 'Operator',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return FlowSaleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FlowSaleQuery(get_called_class());
    }

    public static function generateNewInNumber()
    {
        $latestOrder = FlowSale::find()
            ->orderBy(['id' => SORT_DESC])
            ->one();
        $latestNumber = isset($latestOrder->sale_number) ? $latestOrder->sale_number : '';
        $list = explode('-', $latestNumber);
        $order = isset($list[2]) ? ($list[2]+1) : 1;
        return 'Sell-'.date("Ymd", time()).'-'.$order;
    }
}
