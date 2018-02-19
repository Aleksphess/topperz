<?php
/*
 *  Services
 * */

class admin_services extends AdminTable
{
    public $SORT = 'sort ASC';
	public $IMG_SIZE = 100;
	public $IMG_RESIZE_TYPE = 1;
	public $IMG_BIG_SIZE = 250;
	public $IMG_BIG_VSIZE = 250;
	public $IMG_NUM = 0;
	public $ECHO_NAME = 'name';


	public $NAME = "Услуги";
	public $NAME2 = "услугу";

	
	public $MULTI_LANG = 1;
	
	function __construct()
	{
		$this->fld = [
	
			new Field("name","Название",1, ['multiLang'=>1]),
			new Field("price","Цена,грн",1),
            new Field("type","Для кого",10, array('showInList'=>1, 'values'=>['для покупателей франшизы', 'для продавцов франшизы'])),
			new Field("hide","Не відображати",6, ['showInList'=>1]),
			new Field("sort","SORT",4),
			new Field("creation_time","Date of creation",4),
			new Field("update_time","Date of update",4),
		];
	}
}
