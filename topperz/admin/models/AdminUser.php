<?php
class admin_user extends AdminTable
{
    public $SORT = 'username ASC';
    public $NAME = 'Пользователи сайта';
    public $NAME2 = 'пользователя';
    public $ECHO_NAME       = 'username';
   
    function __construct() {
        $this->fld = [
            new Field("username","Имя",1),
            new Field("email","E-mail",1, ['showInList'=>1]),
            new Field("phone","Телефон",1, ['showInList'=>1]),

            new Field("password_hash","Хэш пароля",1),
            new Field("password_reset_token","Токен сброса пароля",1),
            new Field("auth_key","Ключ авторизации",1),

            new Field("created_at", "Создан", 1),
            new Field("updated_at", "Обновлен", 1)
        ];
    }

};

