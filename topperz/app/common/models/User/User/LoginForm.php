<?php

namespace app\models\User;

use yii\base\Model;

class LoginForm extends Model
{
	public $email, $password;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['email', 'password'], 'required'],
			[['email'], 'email'],
			[['password'], 'string', 'min' => 6, 'max' => 20],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'E-mail',
			'password' => 'Пароль',
		];
	}
}
