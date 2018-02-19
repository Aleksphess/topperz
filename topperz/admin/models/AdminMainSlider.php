<?php



class admin_main_slider extends AdminTable
{
    public $TABLE = 'main_slider';
    public $IMG_NUM = 1;
    public $IMG_SIZE = 760;
    public $IMG_VSIZE = 425;
    public $IMG_RESIZE_TYPE = 1;
    public $IMG_BIG_SIZE = 1180;
    public $IMG_BIG_VSIZE = 432;
    public $ECHO_NAME = 'title';
    public $SORT = 'sort DESC';
    public $NAME = "слайды";
    public $NAME2 = "слайд";
    public $MULTI_LANG = 1;
    public $IMG_TYPE = 'png';


    function __construct()
    {
        $this->fld[] = new Field("href", "Ссылка", 1);

        $this->fld[] = new Field("title", "название", 1, array('multiLang' => 1));
        $this->fld[] = new Field("sort", "SORT", 4);
        $this->fld[] = new Field("creation_time", "Date of creation", 4);
        $this->fld[] = new Field("update_time", "Date of update", 4);
    }
}