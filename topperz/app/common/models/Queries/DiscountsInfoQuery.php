<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\DiscountsInfo]].
 *
 * @see \common\models\DiscountsInfo
 */
class DiscountsInfoQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\DiscountsInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DiscountsInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
