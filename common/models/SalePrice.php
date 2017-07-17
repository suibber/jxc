<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_price".
 *
 * @property integer $id
 * @property string $receiver
 * @property string $model
 * @property string $price
 * @property string $sales
 */
class SalePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['receiver'], 'string', 'max' => 200],
            [['model'], 'string', 'max' => 100],
            [['sales'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receiver' => '收货方',
            'model' => '产品型号',
            'price' => '销售价格',
            'sales' => '销售',
        ];
    }

    /**
     * @inheritdoc
     * @return SalePriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalePriceQuery(get_called_class());
    }
}
