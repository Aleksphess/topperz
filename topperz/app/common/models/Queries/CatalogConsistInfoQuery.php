<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\CatalogConsistInfo]].
 *
 * @see \common\models\CatalogConsistInfo
 */
class CatalogConsistInfoQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\CatalogConsistInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\CatalogConsistInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
