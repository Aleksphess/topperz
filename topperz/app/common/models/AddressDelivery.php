<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address_delivery".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 */
class AddressDelivery extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'address'], 'required'],
            [['user_id'], 'integer'],
            [['address'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'address' => Yii::t('app', 'Address'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\AddressDeliveryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\AddressDeliveryQuery(get_called_class());
    }
}
