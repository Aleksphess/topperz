<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invest".
 *
 * @property integer $id
 * @property string $title
 * @property string $from
 * @property string $to
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 */
class Invest extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'from', 'to', 'sort', 'creation_time', 'update_time'], 'required'],
            [['sort', 'creation_time', 'update_time'], 'integer'],
            [['title', 'from', 'to'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'sort' => Yii::t('app', 'Sort'),
            'creation_time' => Yii::t('app', 'Creation Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}
