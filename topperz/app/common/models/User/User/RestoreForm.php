<?php

namespace app\models\User;

use yii\base\Model;

class RestoreForm extends Model
{
	public $email;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['email'], 'required'],
			[['email'], 'email'],
		];
	}

	public function attributeLabels()
	{
		return [
			'email' => 'E-mail',
		];
	}
}
