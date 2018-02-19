<?php

namespace common\models\Queries;

/**
 * This is the ActiveQuery class for [[\common\models\EmailTemplates]].
 *
 * @see \common\models\EmailTemplates
 */
class EmailTemplatesQuery extends \common\components\BaseActiveQuery
{
    /**
     * @inheritdoc
     * @return \common\models\EmailTemplates[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\EmailTemplates|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}