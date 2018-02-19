<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_label".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property CatalogLabelInfo[] $catalogLabelInfos
 */
class CatalogLabel extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_label';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'sort', 'creation_time', 'update_time'], 'required'],
            [['sort', 'creation_time', 'update_time'], 'integer'],
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
            'alias' => Yii::t('app', 'alias'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogLabelInfos()
    {
        return $this->hasMany(CatalogLabelInfo::className(), ['record_id' => 'id']);
    }
    public function getInfo()
    {
        return $this->hasOne(CatalogLabelInfo::className(), ['record_id'=>'id'])->onCondition([CatalogLabelInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
    /**
     * @inheritdoc
     * @return \common\models\Queries\CatalogLabelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\CatalogLabelQuery(get_called_class());
    }
}
