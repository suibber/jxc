<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FlowSale]].
 *
 * @see FlowSale
 */
class FlowSaleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FlowSale[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FlowSale|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
