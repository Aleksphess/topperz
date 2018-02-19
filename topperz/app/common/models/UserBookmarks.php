<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_bookmarks".
 *
 * @property integer $lot_id
 * @property integer $user_id
 * @property integer $creation_time
 *
 * @property Lots $lot
 * @property User $user
 */
class UserBookmarks extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_bookmarks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lot_id', 'user_id'], 'required'],
            [['lot_id', 'user_id', 'creation_time'], 'integer'],
            [['lot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lots::className(), 'targetAttribute' => ['lot_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lot_id'            => Yii::t('app', 'Lot ID'),
            'user_id'           => Yii::t('app', 'User ID'),
            'creation_time'     => Yii::t('app', 'Creation Time'),
        ];
    }

    public function behaviors() 
    {
        return [
            'timestamps' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'creation_time',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLot()
    {
        return $this->hasOne(Lots::className(), ['id' => 'lot_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\Queries\UserBookmarksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\UserBookmarksQuery(get_called_class());
    }
}
