<?php
/*
 *  Теги (категории материалов)
 * */

class admin_tags extends AdminTable
{
        public $NAME = "Теги";
	public $NAME2 = "тег";  	
        public $ECHO_NAME = 'name';
        public $FIELD_UNDER = 'parent_id';	
	public $MULTI_LANG = 1;
	
	function __construct()
	{
		$this->fld = [
                    new Field("alias","Alias",1),
                    new Field("name","Заголовок",1, array('multiLang'=>1)),
                    new Field("hide","Скрыть",6, array('showInList'=>1, 'editInList'=>1)),
                    new Field("description","Текст",2, array('multiLang'=>1)),
                    new Field("parent_id","Категория тега", 9, array(
                            'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'tags', 'valsFromCategory'=>-1, 
                            'valsEchoField'=>'name')),
                    new Field("sort","SORT",4),
                    new Field("creation_time","Date of creation",4),
                    new Field("update_time","Date of update",4),
		];
        

	}

	

}
