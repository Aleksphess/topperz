<?php
/*
 *  Лоты
 * */

class admin_payment extends AdminTable
{
    public $TABLE           = 'payment';
    public $SORT            = 'id ASC';

    public $ECHO_NAME       = 'name';

    public $FIELD_UNDER     = 'category_id';
    public $NAME            = "Цена";
    public $NAME2           = "цену";

    public $MULTI_LANG      = 0;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(

            new Field("name","Заголовок",1),

            new Field("payment_30","Цена продления на 30 дней",1),
            new Field("payment_90","Цена продления на 90 дней",1),
            new Field("payment_180","Цена продления на 180 дней",1),
            new Field("payment_360","Цена продления на 360 дней",1),

        );
    }


}
