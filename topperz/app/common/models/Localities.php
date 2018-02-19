<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "localities".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_ua
 * @property string $region_name_ru
 * @property string $region_name_ua
 * @property string $type_ru
 * @property string $type_ua
 * @property double $latitude
 * @property double $longitude
 */
class Localities extends \common\components\BaseActiveRecord
{
    
     const DEFAULT_CITY_ID = 9975;
    
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
            [['radius_correction', 'creation_time'], 'integer'],
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
            'radius_correction'     => Yii::t('app', 'Radius Correction'),
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
    
    public static function getAutocompleteArray(string $criteria)
    {
        $search_result = Localities::find()
                ->where(['LIKE', Localities::tableName().'.name_ru', $criteria.'%', false])
                ->limit(10)
                ->orderBy(Localities::tableName().'.name_ru ASC')
                ->asArray()
                ->all();
        
        if(is_null($search_result))
        {
            return false;
        }
        
        $cities = [];
        foreach ($search_result as $res)
        {
            $locality_name =  empty($res['region_name_ru']) ? $res['name_ru'] : $res['name_ru'].' ('.$res['region_name_ru'].')';
            $cities['cities'][] = ['name' => $locality_name, 'id' => $res['id']];
        }
        return $cities;
    }
}