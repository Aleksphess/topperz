<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\Question]].
 *
 * @see \common\models\Question
 */
class QuestionQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Question[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Question|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
