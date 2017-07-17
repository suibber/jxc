<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flow_out".
 *
 * @property integer $id
 * @property string $number
 * @property string $out_number
 * @property string $bill_number
 * @property string $out_store
 * @property string $code_one
 * @property string $code_two
 * @property string $sale_number
 * @property string $model
 * @property integer $quantity
 * @property string $in_one_price
 * @property string $in_price
 * @property string $lot_number
 * @property string $expiration_date_one
 * @property string $expiration_date_two
 * @property string $comment
 * @property string $type
 * @property string $receiver
 * @property string $receiver_short
 * @property string $product_name
 * @property string $operator
 * @property string $created_at
 * @property string $updated_at
 */
class FlowOut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flow_out';
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
            [['number', 'out_number', 'bill_number', 'out_store', 'code_one', 'code_two', 'sale_number', 'model', 'expiration_date_one', 'expiration_date_two', 'type', 'operator'], 'string', 'max' => 100],
            [['lot_number', 'receiver_short'], 'string', 'max' => 200],
            [['comment', 'receiver', 'product_name'], 'string', 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '出库序号',
            'out_number' => '出库单号',
            'bill_number' => '出库序号',
            'out_store' => '出库库房',
            'code_one' => '条形码1',
            'code_two' => '条形码2',
            'sale_number' => '销售单号',
            'model' => '产品型号',
            'quantity' => '出库数量',
            'in_one_price' => '进货单价',
            'in_price' => '进货金额',
            'lot_number' => '批号',
            'expiration_date_one' => '有效期1',
            'expiration_date_two' => '有效期1',
            'comment' => '备注',
            'type' => '分类',
            'receiver' => '收货方',
            'receiver_short' => '收货方简写',
            'product_name' => '产品名称',
            'operator' => 'Operator',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return FlowOutQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FlowOutQuery(get_called_class());
    }
}
