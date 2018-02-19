<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Feedbacks]].
 *
 * @see \common\models\Feedbacks
 */
class FeedbacksQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Feedbacks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Feedbacks|array|null
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
