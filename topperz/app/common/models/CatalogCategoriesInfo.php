<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_categories_info".
 *
 * @property integer $record_id
 * @property string $lang
 * @property string $title
 * @property string $text
 *
 * @property CatalogCategories $record
 */
class CatalogCategoriesInfo extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_categories_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'lang', 'title', 'text'], 'required'],
            [['record_id'], 'integer'],
            [['text'], 'string'],
            [['lang'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 250],
            [['record_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::className(), 'targetAttribute' => ['record_id' => 'id']],
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
            'text' => Yii::t('app', 'Описание категоии'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(CatalogCategories::className(), ['id' => 'record_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogCategoriesInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogCategoriesInfoQuery(get_called_class());
    }
}
