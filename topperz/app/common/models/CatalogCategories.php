<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "catalog_categories".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $active
 * @property integer $category_id
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property CatalogCategoriesInfo[] $catalogCategoriesInfos
 */
class CatalogCategories extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'active', 'sort', 'creation_time', 'update_time'], 'required'],
            [['active', 'category_id', 'sort', 'creation_time', 'update_time'], 'integer'],
            [['alias'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias (генерируеться, если не заполнен)'),
            'active' => Yii::t('app', 'Активна'),
            'category_id' => Yii::t('app', 'Category ID'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategoriesInfos()
    {
        return $this->hasMany(CatalogCategoriesInfo::className(), ['record_id' => 'id']);
    }
    public function getInfo()
    {
        return $this->hasOne(CatalogCategoriesInfo::className(), ['record_id'=>'id'])->onCondition([CatalogCategoriesInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
    public function getProducts()
    {
        return $this->hasMany(CatalogProducts::className(), ['category_id' => 'id']);
    }
    public function getImgPng()
    {


        if(is_file($_SERVER['DOCUMENT_ROOT'] . 'images/'. $this->tableName().'/'.$this->id.".1.b.png"))
        {
            return '/images/'. $this->tableName().'/'.$this->id.".1.b.png";
        }
        else
        {
            return '/images/no-img.png';
        }
    }

    public function getUrl()
    {
        return Url::toRoute('/'.$this->alias);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogCategoriesQuery(get_called_class());
    }
}
