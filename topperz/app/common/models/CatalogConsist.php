<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_consist".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property CatalogConsistInfo[] $catalogConsistInfos
 */
class CatalogConsist extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_consist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sort', 'creation_time', 'update_time'], 'required'],
            [['product_id', 'sort', 'creation_time', 'update_time'], 'integer'],
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
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogConsistInfos()
    {
        return $this->hasMany(CatalogConsistInfo::className(), ['record_id' => 'id']);
    }
    public function getInfo()
    {
        return $this->hasOne(CatalogConsistInfo::className(), ['record_id'=>'id'])->onCondition([CatalogConsistInfo::tableName().'.lang' => Lang::getCurrentId()]);
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
     * @inheritdoc
     * @return \common\models\Queries\CatalogConsistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogConsistQuery(get_called_class());
    }
}
