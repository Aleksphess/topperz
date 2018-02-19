<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "messaging".
 *
 * @property integer $id
 * @property string $emai
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 */
class Messaging extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messaging';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['sort', 'creation_time', 'update_time'], 'integer'],
            [['email'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'emai' => Yii::t('app', 'Emai'),
            'sort' => Yii::t('app', 'Sort'),
            'creation_time' => Yii::t('app', 'Creation Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}
