<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_params".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $value
 * @property string $price
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property CatalogParamsInfo[] $catalogParamsInfos
 */
class CatalogParams extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'value', 'price', 'sort', 'creation_time', 'update_time'], 'required'],
            [['product_id', 'sort', 'creation_time', 'update_time'], 'integer'],
            [['value', 'price'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Относится к категории'),
            'value' => Yii::t('app', 'Значение'),
            'price' => Yii::t('app', 'Цена'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogParamsInfos()
    {
        return $this->hasMany(CatalogParamsInfo::className(), ['record_id' => 'id']);
    }

    public function getInfo()
    {
        return $this->hasOne(CatalogParamsInfo::className(), ['record_id'=>'id'])->onCondition([CatalogParamsInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }

    public function getParent()
    {
        return $this->hasOne(CatalogProducts::className(), ['id'=>'product_id']);
    }
    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogParamsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogParamsQuery(get_called_class());
    }
}
