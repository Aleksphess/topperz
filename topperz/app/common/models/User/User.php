<?php

namespace common\models\User;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    private static $current = NULL;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, function(){
            $this->password = sha1($this->password);
            return true;
        });
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
            return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
                [['name', 'phone', 'created'], 'required'],
                [['name'], 'string', 'min' => 2, 'max' => 100],
                [['password'], 'string', 'min' => 6, 'max' => 20],
                [['address'], 'string', 'min' => 10],
                [['email'], 'email'],
//                [['email'], 'unique'],
        ];

        if($this->isNewRecord)
        {
            $rules[] = [['password'], 'required'];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Ваше Имя'),
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'address' => Yii::t('app', 'Адрес доставки'),
            'created' => Yii::t('app', 'Дата регистрации'),
        ];
    }

    public static function getCurrent()
    {
        if (is_null(self::$current))
        {
            self::$current = false;
            if (Yii::$app->user->id > 0)
            {
                self::$current = self::findIdentity(Yii::$app->user->id);
            }
            else
            {
                self::$current = new self();
            }
        }

        return self::$current;
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    //	Метод возвращает список пунктов меню личного кабинета
    public function getMenu()
    {
        $menu = [
            [
                'name' => Yii::t('app', 'Персональные данные'),
                'url' => Url::toRoute(['/user/profile'])
            ],
            [
                'name' => Yii::t('app', 'История заказов'),
                'url' => Url::toRoute(['/user/orders'])
            ],
            [
                'name' => Yii::t('app', 'Список желаний'),
                'url' => Url::toRoute(['/user/wishlist'])
            ],
            [
                'name' => Yii::t('app', 'Корзина'),
                'url' => Url::toRoute(['/user/cart'])
            ],
        ];

        if (!$this->id)
        {
            array_unshift($menu, [
                    'name' => Yii::t('app', 'Авторизация'),
                    'url' => Url::toRoute(['/user/auth'])
            ]);
        }

        return $menu;
    }



    /*
     *	Генератор случайного пароля
     */
    public static function getRandomPassword($length = 8)
    {
        //	Формирую массив допустимых для пароля символов
        $chars = [];
        for ($i = 0; $i <= 9; $i++)
        {
            $chars[] = $i;
        }
        for ($i = 65; $i <= 90; $i++)
        {
            $chars[] = chr($i);
        }
        for ($i = 0; $i <= 9; $i++)
        {
            $chars[] = $i;
        }
        for ($i = 97; $i <= 122; $i++)
        {
            $chars[] = chr($i);
        }
        for ($i = 0; $i <= 9; $i++)
        {
            $chars[] = $i;
        }

        //	Формирую пароль
        $pass = '';
        $char_count = count($chars);
        for ($i = 0; $i < $length; $i++)
        {
            $pass .= $chars[rand(0, $char_count - 1)];
        }
        return $pass;
    }
}