<?php

class admin_callback extends AdminTable
{
    public $TABLE               = 'callback';

    public $ECHO_NAME           = 'name';
    public $SORT                = 'sort DESC';
    public $RUBS_NO_UNDER       = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME                = "Обратный звонок";
    public $NAME2               = "обратный звонок";

    function __construct()
    {
        $this->fld[] = new Field("name","Имя",1);
        $this->fld[] = new Field("phone","Телефон",1);
        $this->fld[] = new Field("user_id","Пользователь",9, array(
            'showInList'=>1, 'editInList'=>0, 'valsFromTable'=>'user','valsEchoField'=>'email'));
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }


}
class admin_mail_message extends AdminTable
{
    public $TABLE               = 'mail_message';

    public $ECHO_NAME           = 'email';
    public $SORT                = 'id DESC';
    public $RUBS_NO_UNDER       = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME                = "Сообщение";
    public $NAME2               = "сообщение";

    function __construct()
    {
        $this->fld[] = new Field("email","Email",1);
        $this->fld[] = new Field("comment","Text",16);

        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }


}

class admin_question extends AdminTable
{
    public $TABLE               = 'question';

    public $ECHO_NAME           = 'name';
    public $SORT                = 'sort DESC';
    public $RUBS_NO_UNDER       = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME                = "Вопрос";
    public $NAME2               = "вопрос";

    function __construct()
    {
        $this->fld[] = new Field("name","Имя",1);
        $this->fld[] = new Field("phone","phone",1);
        $this->fld[] = new Field("question","Вопрос",1);
        $this->fld[] = new Field("user_id","Пользователь",9, array(
            'showInList'=>1, 'editInList'=>0, 'valsFromTable'=>'user','valsEchoField'=>'email'));
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }


}
class admin_messaging extends AdminTable
{
    public $TABLE               = 'messaging';

    public $ECHO_NAME           = 'email';
    public $SORT                = 'sort DESC';
    public $RUBS_NO_UNDER       = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME                = "почту в рассылку";
    public $NAME2               = "почту в рассылку";

    function __construct()
    {

        $this->fld[] = new Field("email","email",1);
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }


}
