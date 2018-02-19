<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "topic_products_assoc".
 *
 * @property integer $topic_id
 * @property integer $product_id
 */
class TopicProductsAssoc extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic_products_assoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'product_id'], 'required'],
            [['topic_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'topic_id' => Yii::t('app', 'Topic ID'),
            'product_id' => Yii::t('app', 'Product ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\TopicProductsAssocQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\TopicProductsAssocQuery(get_called_class());
    }
    public function getTopic()
    {
        return $this->hasOne(CatalogTopic::className(), ['id' => 'topic_id']);

    }
}
