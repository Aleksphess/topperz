<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\PagesInfo]].
 *
 * @see \common\models\PagesInfo
 */
class PagesInfoQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\PagesInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\PagesInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
