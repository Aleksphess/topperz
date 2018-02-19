<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_info".
 *
 * @property integer $record_id
 * @property string $lang
 * @property string $title
 *
 * @property Menu $record
 */
class MenuInfo extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'lang', 'title'], 'required'],
            [['record_id'], 'integer'],
            [['lang'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 250],
            [['record_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['record_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'record_id' => Yii::t('app', 'Record ID'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'название'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Menu::className(), ['id' => 'record_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\MenuInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\MenuInfoQuery(get_called_class());
    }
}
