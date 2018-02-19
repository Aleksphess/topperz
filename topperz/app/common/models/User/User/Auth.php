<?php

namespace app\models\User;

use yii\base\Model;

class Auth extends Model
{
	public static $user = NULL;

	public static function login($email, $password)
	{
		$u = User::find()->where(['email' => $email, 'password' => sha1($password)]);
		$u = $u->one();
		if ($u->id > 0)
		{
			self::$user = $u;

			return TRUE;
		}

		return FALSE;
	}
}