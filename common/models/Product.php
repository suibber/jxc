<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $number
 * @property string $model
 * @property string $name
 * @property string $alias
 * @property string $manufacturer
 * @property string $service
 * @property string $suppliers
 * @property string $register_id
 * @property string $price
 * @property string $type
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['number', 'model'], 'string', 'max' => 100],
            [['name', 'alias', 'manufacturer', 'service', 'suppliers'], 'string', 'max' => 400],
            [['register_id'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => '产品编码',
            'model' => '产品型号',
            'name' => '产品名称',
            'alias' => '产品别名',
            'manufacturer' => '生产商',
            'service' => '服务机构',
            'suppliers' => '供应商',
            'register_id' => '医疗器械注册证',
            'price' => '采购价格',
            'type' => '分类',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public static function getAllSupplier()
    {
        $list = Product::find()
            ->distinct(['suppliers'])
            ->select(['suppliers'])
            ->where(['!=', 'suppliers', ''])
            ->asArray()
            ->all();
        return array_column($list, 'suppliers');
    }

    public static function getProductInfoByModel($model)
    {
        $info = Product::find()
            ->where(['model' => $model])
            ->one();
        return $info;
    }
}
