<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "callback".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property integer $user_id
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 */
class Callback extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'callback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'user_id', 'creation_time'], 'required'],
            [['user_id', 'sort', 'creation_time', 'update_time'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'phone' => Yii::t('app', 'Телефон'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\CallbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CallbackQuery(get_called_class());
    }
}
