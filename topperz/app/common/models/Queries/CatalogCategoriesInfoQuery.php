<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\CatalogCategoriesInfo]].
 *
 * @see \common\models\CatalogCategoriesInfo
 */
class CatalogCategoriesInfoQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\CatalogCategoriesInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\CatalogCategoriesInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
