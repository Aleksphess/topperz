<?php

class admin_country extends AdminTable
{
    public $TABLE = 'country';

    public $ECHO_NAME = 'title';
    public $SORT = 'sort DESC';
    public $RUBS_NO_UNDER = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME = "Страна";
    public $NAME2 = "страну";
    public $MULTI_LANG = 1;

    function __construct()
    {
        $this->fld[] = new Field("title", "Заголовок", 1, array('multiLang' => 1));

        $this->fld[] = new Field("sort", "SORT", 4);
        $this->fld[] = new Field("creation_time", "Date of creation", 4);
        $this->fld[] = new Field("update_time", "Date of update", 4);
    }
}


?>
<?php

class admin_invest extends AdminTable
{
    public $TABLE = 'invest';

    public $ECHO_NAME = 'title';
    public $SORT = 'sort DESC';
    public $RUBS_NO_UNDER = 1;
//    public $FIELD_UNDER         = 'parent_id';
    public $NAME = "Страна";
    public $NAME2 = "страну";


    function __construct()
    {
        $this->fld[] = new Field("title", "Заголовок", 1);
        $this->fld[] = new Field("from", "от", 1);
        $this->fld[] = new Field("to", "до", 1);

        $this->fld[] = new Field("sort", "SORT", 4);
        $this->fld[] = new Field("creation_time", "Date of creation", 4);
        $this->fld[] = new Field("update_time", "Date of update", 4);
    }
}


?>
