<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FlowOrder]].
 *
 * @see FlowOrder
 */
class FlowOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FlowOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FlowOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
