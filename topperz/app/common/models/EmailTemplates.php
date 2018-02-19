<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_templates".
 *
 * @property integer $id
 * @property string $alias
 * @property string $send_to
 * @property string $subject
 * @property string $text
 * @property integer $creation_time
 * @property integer $update_time
 */
class EmailTemplates extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'send_to', 'text', 'creation_time'], 'required'],
            [['send_to', 'text'], 'string'],
            [['creation_time', 'update_time'], 'integer'],
            [['alias', 'subject'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'alias'                 => Yii::t('app', 'Alias'),
            'send_to'               => Yii::t('app', 'Send To'),
            'subject'               => Yii::t('app', 'Subject'),
            'text'                  => Yii::t('app', 'Text'),
            'creation_time'         => Yii::t('app', 'Creation Time'),
            'update_time'           => Yii::t('app', 'Update Time'),
        ];
    }

    public function behaviors() 
    {
        return [
            'timestamps' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'creation_time',
                'updatedAtAttribute' => 'update_time',
            ]
        ];
    }
    
    /**
     * @inheritdoc
     * @return \common\models\Queries\EmailTemplatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\EmailTemplatesQuery(get_called_class());
    }
}