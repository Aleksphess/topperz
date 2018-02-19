<?php

class admin_catalog_categories extends AdminTable
{
	
    public $TABLE = 'catalog_categories';
    public $IMG_SIZE = 370; // макс высота 
    public $IMG_VSIZE = 240; 
    public $IMG_RESIZE_TYPE = 5; //рeсайз по высоте
    public $IMG_BIG_SIZE = 600 ;
    public $IMG_BIG_VSIZE = 400;
    public $IMG_NUM = 1;
    public $ECHO_NAME = 'name';
    public $SORT = 'sort DESC';
//    public $RUBS_NO_UNDER = 1;
    public $FIELD_UNDER = 'parent_id';

    public $NAME = "Категории товаров";
    public $NAME2 = "категорию";

    public $MULTI_LANG = 1;

    function __construct()
    {
        $this->fld[] = new Field("name","Заголовок",1, array('multiLang'=>1));
        $this->fld[] = new Field("text","Описание категоии",2, array('multiLang'=>1));
        $this->fld[] = new Field("alias","Alias (генерируеться, если не заполнен)",1);
        $this->fld[] = new Field("active","Активна",6,array('showInList'=>1, 'editInList'=>1));
        $this->fld[] = new Field("parent_id","Относиться к категории", 9, array(
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=> $this->TABLE, 'valsFromCategory'=>-1, 
                'LEVELS'=> 1, 'valsEchoField'=>'name'));
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }
    
    function afterAdd($row) {    

        if (empty($row['alias'])) {
            $qup = "UPDATE " . $this->TABLE . " SET alias = '" . Translit($row['name_1'])."' WHERE id = " 
            . $row['id'];
            pdoExec($qup);
        }
        
//        if (empty($row['custom_date'])) {;
//
//            $qup = "UPDATE projects SET custom_date = '"
//                . gmdate('d.m.Y', $row['creation_time'])
//                ."' WHERE id = " . $row['id'];
//            pdoExec($qup);
//        }
       
    }
    
    function afterEdit($row)
    {
        $this->afterAdd($row);       
    }
}