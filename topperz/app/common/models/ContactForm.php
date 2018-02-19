<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_form".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $text
 * @property integer $is_processed
 * @property integer $creation_time
 */
class ContactForm extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'text'], 'required'],
            [['name', 'phone', 'email', 'text'], 'string'],
            [['name', 'phone', 'email', 'text'], 'trim'],
            [['is_processed', 'creation_time'], 'integer'],
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class'              => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'creation_time',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'name'                  => Yii::t('app', 'Name'),
            'phone'                 => Yii::t('app', 'Phone'),
            'email'                 => Yii::t('app', 'Email'),
            'text'                  => Yii::t('app', 'Text'),
            'is_processed'          => Yii::t('app', 'Is Processed'),
            'creation_time'         => Yii::t('app', 'Creation Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\ContactFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\ContactFormQuery(get_called_class());
    }
}