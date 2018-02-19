<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Seo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

	public function getInfo()
    {
        return $this->hasOne(SeoInfo::className(), ['record_id'=>'id'])->onCondition([SeoInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
}
