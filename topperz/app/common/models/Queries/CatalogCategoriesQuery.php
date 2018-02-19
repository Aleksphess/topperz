<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\CatalogCategories]].
 *
 * @see \common\models\CatalogCategories
 */
class CatalogCategoriesQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\CatalogCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\CatalogCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function active()
    {
        return $this->andWhere(['active'=>1]);
    }

    public function bottom()
    {
        return $this->andWhere(['bottom'=>1]);
    }
}
