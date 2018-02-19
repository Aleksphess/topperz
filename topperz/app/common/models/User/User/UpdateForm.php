<?php

namespace app\models\User;

use Yii;
use yii\base\Model;

class UpdateForm extends Model
{
    public $name, $address, $email, $phone;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
			[['email', 'name'], 'required'],
			['name', 'string', 'min' => 2, 'max' => 100],
			['email', 'email'],
			['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\app\models\User\User', 'filter' => '`id`!='.(int)User::getCurrent()->getId()],
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
