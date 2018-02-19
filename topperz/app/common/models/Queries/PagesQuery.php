<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Pages]].
 *
 * @see \common\models\Pages
 */
class PagesQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Pages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Pages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
