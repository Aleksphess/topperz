<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "catalog_products".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $category_id
 * @property string $also_ids
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property CatalogProductsInfo[] $catalogProductsInfos
 */
class CatalogProducts extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'category_id', 'also_ids', 'sort', 'creation_time', 'update_time'], 'required'],
            [['category_id', 'sort', 'creation_time', 'update_time'], 'integer'],
            [['alias', 'also_ids'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Алиас'),
            'category_id' => Yii::t('app', 'Относится к категории'),
            'also_ids' => Yii::t('app', 'Товары, которые рекомендуются покупать вместе с данным
             (ID товаров через запятую, пример: 545,567)'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
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
    public function getCatalogProductsInfos()
    {
        return $this->hasMany(CatalogProductsInfo::className(), ['record_id' => 'id']);
    }
    public function getInfo()
    {
        return $this->hasOne(CatalogProductsInfo::className(), ['record_id'=>'id'])->onCondition([CatalogProductsInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
    public function getParams()
    {
        return $this->hasMany(CatalogParams::className(), ['product_id' => 'id']);
    }
    public function getConsist()
    {
        return $this->hasMany(CatalogConsist::className(), ['product_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(CatalogCategories::className(), ['id'=>'category_id']);
    }
    public function getUrl()
    {
        return Url::toRoute('/'.$this->parent->alias.'/'.$this->alias);
    }
    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogProductsQuery(get_called_class());
    }
}
