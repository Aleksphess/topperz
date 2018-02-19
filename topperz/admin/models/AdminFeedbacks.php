<?php

class admin_feedbacks extends AdminTable
{
    public $TABLE               = 'feedbacks';

    public $ECHO_NAME           = 'name';
    public $SORT                = 'sort DESC';
    public $RUBS_NO_UNDER       = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME                = "Отзывы";
    public $NAME2               = "Отзыв";

    function __construct()
    {
        $this->fld[] = new Field("name","Имя",1);
        $this->fld[] = new Field("email","Email",1);
        $this->fld[] = new Field("text","Текст",16);
        $this->fld[] = new Field("mark","Оценка",1);
        $this->fld[] = new Field("active", 'Обработан', 6, ['showInList'=>1,'editInList'=>1]);
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }


}