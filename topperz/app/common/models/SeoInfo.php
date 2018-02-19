<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class SeoInfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_info';
    }
}
