<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Discounts]].
 *
 * @see \common\models\Discounts
 */
class DiscountsQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Discounts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Discounts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function active()
    {
        return $this->andWhere(['active'=>1]);
    }
}
