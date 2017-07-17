<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FlowOut]].
 *
 * @see FlowOut
 */
class FlowOutQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FlowOut[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FlowOut|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
