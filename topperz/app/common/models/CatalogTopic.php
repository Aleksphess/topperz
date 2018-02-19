<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_topic".
 *
 * @property integer $id
 * @property string $price
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 * @property integer $product_id
 *
 * @property CatalogTopicInfo[] $catalogTopicInfos
 */
class CatalogTopic extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'sort', 'creation_time', 'update_time', 'product_id'], 'required'],
            [['sort', 'creation_time', 'update_time', 'product_id'], 'integer'],
            [['price'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price' => Yii::t('app', 'Цена за 1 топик'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
            'product_id' => Yii::t('app', 'Product ID'),
        ];
    }
    public function behaviors()
    {
        return [
            'timestamps' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'creation_time',
                'updatedAtAttribute' => 'update_time',
            ],
            'thumb' => [
                'class' => \common\components\behavior\ImgBehavior::className()
            ],
//            'translit' => [
//                'class' => \common\components\behavior\TranslitBehavior::className()
//            ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogTopicInfos()
    {
        return $this->hasMany(CatalogTopicInfo::className(), ['record_id' => 'id']);
    }
    public function getInfo()
    {
        return $this->hasOne(CatalogTopicInfo::className(), ['record_id'=>'id'])->onCondition([CatalogTopicInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogTopicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogTopicQuery(get_called_class());
    }
}
