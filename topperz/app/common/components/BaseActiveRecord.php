<?php

namespace common\components;

use Yii;

/**
 * This is the base model class for tables.
 *

 */
class BaseActiveRecord extends \yii\db\ActiveRecord
{
     const IMG_COUNT = 10;
    
    public function img_count_const()
    {
        return self::IMG_COUNT;
    }
}