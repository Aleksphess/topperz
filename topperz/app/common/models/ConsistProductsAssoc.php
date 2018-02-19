<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "consist_products_assoc".
 *
 * @property integer $product_id
 * @property integer $consist_id
 */
class ConsistProductsAssoc extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consist_products_assoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'consist_id'], 'required'],
            [['product_id', 'consist_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'consist_id' => Yii::t('app', 'Consist ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\ConsistProductsAssocQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\ConsistProductsAssocQuery(get_called_class());
    }
    public function getConsist()
    {
        return $this->hasOne(CatalogConsist::className(), ['id' => 'consist_id']);

    }
}
