<?php

namespace common\modules\novaposhta\models;

use Yii;
/**
 * Description of Localities
 *
 * @author kossworth
 */
class Localities extends \common\components\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'localities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creation_time'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['name_ru', 'name_ua', 'area_name_ru', 'area_name_ua', 'region_name_ru', 'region_name_ua'], 'string', 'max' => 100],
            [['type_ru', 'type_ua'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'name_ru'               => Yii::t('app', 'Name Ru'),
            'name_ua'               => Yii::t('app', 'Name Ua'),
            'region_name_ru'        => Yii::t('app', 'Region Name Ru'),
            'region_name_ua'        => Yii::t('app', 'Region Name Ua'),
            'area_name_ru'          => Yii::t('app', 'Area Name Ru'),
            'area_name_ua'          => Yii::t('app', 'Area Name Ua'),
            'type_ru'               => Yii::t('app', 'Type Ru'),
            'type_ua'               => Yii::t('app', 'Type Ua'),
            'latitude'              => Yii::t('app', 'Latitude'),
            'longitude'             => Yii::t('app', 'Longitude'),
            'creation_time'         => Yii::t('app', 'Creation Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\LocalitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\LocalitiesQuery(get_called_class());
    }
    
}