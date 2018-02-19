<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\app\models\OrdersItems]].
 *
 * @see \app\models\OrdersItems
 */
class OrdersItemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\OrdersItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\OrdersItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
