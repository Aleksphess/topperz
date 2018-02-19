<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $href
 * @property string $alias
 * @property integer $top_menu
 * @property integer $buttom_menu
 * @property integer $sort
 * @property integer $creation_time
 * @property integer $update_time
 *
 * @property MenuInfo[] $menuInfos
 */
class Menu extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['href', 'alias', 'top_menu', 'buttom_menu', 'sort', 'creation_time', 'update_time'], 'required'],
            [['top_menu', 'buttom_menu', 'sort', 'creation_time', 'update_time'], 'integer'],
            [['href', 'alias'], 'string', 'max' => 250],
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
            'alias' => Yii::t('app', 'alias'),
            'top_menu' => Yii::t('app', 'Вывести в верхнем меню'),
            'buttom_menu' => Yii::t('app', 'Вывести в нижнем меню'),
            'sort' => Yii::t('app', 'SORT'),
            'creation_time' => Yii::t('app', 'Date of creation'),
            'update_time' => Yii::t('app', 'Date of update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuInfos()
    {
        return $this->hasMany(MenuInfo::className(), ['record_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\MenuQuery(get_called_class());
    }
    public function getInfo()
    {
        return $this->hasOne(MenuInfo::className(), ['record_id'=>'id'])->onCondition([MenuInfo::tableName().'.lang' => Lang::getCurrentId()]);
    }
    public function getUrl()
    {
        return Url::toRoute('/'.$this->alias);
    }
}
