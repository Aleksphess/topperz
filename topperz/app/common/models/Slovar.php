<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slovar".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $parent_id
 * @property integer $creation_time
 * @property integer $update_time
 * @property integer $sort
 *
 * @property SlovarInfo[] $slovarInfos
 */
class Slovar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slovar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'parent_id', 'creation_time', 'update_time', 'sort'], 'required'],
            [['parent_id', 'creation_time', 'update_time', 'sort'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название'),
            'alias' => Yii::t('app', 'Алиас'),
            'parent_id' => Yii::t('app', 'В разделе'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
            'sort' => Yii::t('app', 'SORT'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlovarInfos()
    {
        return $this->hasMany(SlovarInfo::className(), ['record_id' => 'id']);
    }
    
    public function getInfo()
    {
        return $this->hasOne(SlovarInfo::className(), ['record_id'=>'id'])->where([SlovarInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\Slovar the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\Slovar(get_called_class());
    }
}
