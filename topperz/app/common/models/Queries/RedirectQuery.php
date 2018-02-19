<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Redirect]].
 *
 * @see \common\models\Redirect
 */
class RedirectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Redirect[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Redirect|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
