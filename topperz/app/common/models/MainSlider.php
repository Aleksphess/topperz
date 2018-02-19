<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "main_slider".
 *
 * @property integer $id
 * @property string $href
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property MainSliderInfo[] $mainSliderInfos
 */
class MainSlider extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['href', 'sort', 'creation_time', 'update_time'], 'required'],
            [['sort', 'creation_time', 'update_time'], 'integer'],
            [['href'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'href' => Yii::t('app', 'Ссылка'),
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
    public function getMainSliderInfos()
    {
        return $this->hasMany(MainSliderInfo::className(), ['record_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\MainSliderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\MainSliderQuery(get_called_class());
    }
    public function getInfo()
    {
        return $this->hasOne(MainSliderInfo::className(), ['record_id'=>'id'])->onCondition([MainSliderInfo::tableName().'.lang' => Lang::getCurrentId()]);
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
}
