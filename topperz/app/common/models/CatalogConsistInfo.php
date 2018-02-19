<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_consist_info".
 *
 * @property integer $record_id
 * @property string $lang
 * @property string $title
 *
 * @property CatalogConsist $record
 */
class CatalogConsistInfo extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_consist_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'lang', 'title'], 'required'],
            [['record_id'], 'integer'],
            [['lang'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 250],
            [['record_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogConsist::className(), 'targetAttribute' => ['record_id' => 'id']],
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
            'title' => Yii::t('app', 'Название'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(CatalogConsist::className(), ['id' => 'record_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogConsistInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogConsistInfoQuery(get_called_class());
    }
}
