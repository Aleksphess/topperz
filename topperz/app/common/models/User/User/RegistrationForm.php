<?php

namespace app\models\User;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $name, $email, $password, $password_confirm, $phone;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
			[['email', 'name', 'password', 'password_confirm'], 'required'],
			['name', 'string', 'min' => 2, 'max' => 100],
			['email', 'email'],
			['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\app\models\User\User'],
			[['password', 'password_confirm'], 'string', 'min' => 6, 'max' => 20],
			['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => Yii::t('app', "Пароли не совпадают")],
			['phone', 'match', 'pattern' => '#^\+38 \(0\d\d\) \d\d\d-\d\d-\d\d$#', 'message' => Yii::t('app', 'Введите номер телефона в формате <nobr>+38 (0xx) xxx-xx-xx</nobr>')],
        ];
    }

	public function attributeLabels()
	{
		return [
			'name' => Yii::t('app', 'Ваше Имя'),
			'email' => 'E-mail',
			'password' => 'Пароль',
			'password_confirm' => Yii::t('app', 'Подтвердите пароль'),
			'phone' => 'Телефон',
		];
	}
}
