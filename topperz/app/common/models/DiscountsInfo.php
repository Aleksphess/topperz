<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discounts_info".
 *
 * @property integer $record_id
 * @property string $lang
 * @property string $title
 * @property string $title_on_button
 * @property string $short_description
 * @property string $text
 *
 * @property Discounts $record
 */
class DiscountsInfo extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discounts_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'lang', 'title', 'title_on_button', 'short_description', 'text'], 'required'],
            [['record_id'], 'integer'],
            [['text'], 'string'],
            [['lang'], 'string', 'max' => 3],
            [['title', 'title_on_button', 'short_description'], 'string', 'max' => 250],
            [['record_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discounts::className(), 'targetAttribute' => ['record_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'record_id' => Yii::t('app', 'Record ID'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Заголовок'),
            'title_on_button' => Yii::t('app', 'Текст на кнопке'),
            'short_description' => Yii::t('app', 'Короткое описание'),
            'text' => Yii::t('app', 'Текст'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Discounts::className(), ['id' => 'record_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\DiscountsInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\DiscountsInfoQuery(get_called_class());
    }
}
