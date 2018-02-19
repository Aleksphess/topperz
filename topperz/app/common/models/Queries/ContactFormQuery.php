<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\ContactForm]].
 *
 * @see \common\models\ContactForm
 */
class ContactFormQuery extends \common\components\BaseActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ContactForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ContactForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
