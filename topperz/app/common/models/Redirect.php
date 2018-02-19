<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "redirect".
 *
 * @property integer $id
 * @property string $redirect_from
 * @property string $redirect_to
 * @property string $comment
 * @property integer $creation_time
 */
class Redirect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'redirect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['redirect_from', 'redirect_to', 'creation_time'], 'required'],
            [['redirect_from', 'redirect_to', 'comment'], 'string'],
            [['creation_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'redirect_from' => Yii::t('app', 'Redirect From'),
            'redirect_to' => Yii::t('app', 'Redirect To'),
            'comment' => Yii::t('app', 'Comment'),
            'creation_time' => Yii::t('app', 'Creation Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\RedirectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\RedirectQuery(get_called_class());
    }
}
