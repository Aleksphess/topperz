<?php
class admin_pages extends AdminTable
{
    public $TABLE               = 'pages';
    public $IMG_SIZE            = 300; // макс высота
    public $IMG_VSIZE           = 100;
    public $IMG_RESIZE_TYPE     = 5;
    public $IMG_BIG_SIZE        = 1000 ;
    public $IMG_BIG_VSIZE       = 333;
    public $IMG_NUM             = 0;
    public $ECHO_NAME           = 'title';
    public $SORT                = 'sort DESC';
    public $RUBS_NO_UNDER       = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME                = "Страницы";
    public $NAME2               = "страницу";
    public $MULTI_LANG          = 1;
    function __construct()
    {
        $this->fld[] = new Field("title","Заголовок",1, array('multiLang'=>1));

        $this->fld[] = new Field("text","Текст",2, array('multiLang'=>1));

        $this->fld[] = new Field("alias","Alias (генерируеться, если не заполнен)",1);
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }

    function afterAdd($row)
    {
        if (empty($row['alias'])) {
            $qup = "UPDATE ".$this->TABLE." SET alias = '" . Translit($row['title_1'])."' WHERE id = " . $row['id'];
            pdoExec($qup);
        }
        YandexTranslate($row, $this->TABLE);
    }

    function afterEdit($row)
    {
        $this->afterAdd($row);
    }
}


