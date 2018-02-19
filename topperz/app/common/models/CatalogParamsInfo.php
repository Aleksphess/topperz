<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_params_info".
 *
 * @property integer $record_id
 * @property string $lang
 * @property string $title
 * @property string $type
 *
 * @property CatalogParams $record
 */
class CatalogParamsInfo extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_params_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'lang', 'title', 'type'], 'required'],
            [['record_id'], 'integer'],
            [['lang'], 'string', 'max' => 3],
            [['title', 'type'], 'string', 'max' => 250],
            [['record_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogParams::className(), 'targetAttribute' => ['record_id' => 'id']],
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
            'type' => Yii::t('app', 'Тип(л,см)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(CatalogParams::className(), ['id' => 'record_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogParamsInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogParamsInfoQuery(get_called_class());
    }
}
