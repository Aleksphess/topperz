<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slovar_info".
 *
 * @property integer $record_id
 * @property integer $lang
 * @property string $value
 *
 * @property Slovar $record
 */
class SlovarInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slovar_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'lang', 'value'], 'required'],
            [['record_id', 'lang'], 'integer'],
            [['value'], 'string', 'max' => 250],
            [['record_id'], 'exist', 'skipOnError' => true, 'targetClass' => Slovar::className(), 'targetAttribute' => ['record_id' => 'id']],
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
            'value' => Yii::t('app', 'Значение'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Slovar::className(), ['id' => 'record_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\SlovarInfo the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\SlovarInfo(get_called_class());
    }
}
