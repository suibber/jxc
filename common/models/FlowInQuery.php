<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FlowIn]].
 *
 * @see FlowIn
 */
class FlowInQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FlowIn[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FlowIn|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
