<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedbacks".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $mark
 * @property integer $active
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 */
class Feedbacks extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedbacks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'mark', 'creation_time'], 'required'],
            [['active', 'sort', 'creation_time', 'update_time'], 'integer'],
            [['name', 'text', 'mark'], 'string', 'max' => 250],
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
            'text' => Yii::t('app', 'Телефон'),
            'mark' => Yii::t('app', 'Оценка'),
            'active' => Yii::t('app', 'Обработан'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\FeedbacksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\FeedbacksQuery(get_called_class());
    }
}
