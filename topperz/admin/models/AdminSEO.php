<?php
/*
 *  SEO тексты
 */

class admin_seo extends AdminTable
{
    public $SORT       = 'type DESC';
    public $TABLE      = 'seo';
    public $ECHO_NAME  = 'url';
    public $NAME       = "SEO тексты";
    public $NAME2      = "страницу";
    public $MULTI_LANG = 1;
    public $IMG_NUM    = 0;

    function __construct()
    {
        $this->fld=array(
            new Field("url","URL (product)",1),
            new Field("type","Тип шаблона",10, array('showInList'=>1, 'values'=>['template', 'static'])),
            new Field("title","TITLE",1, array('multiLang'=>1, 'showInList'=>1)),
            new Field("description","Description",1, array('multiLang'=>1)),
            new Field("h1","Заголовок H1",1, array('multiLang'=>1, 'showInList'=>1)),
            new Field("cannonical","Канонническая ссылка",1, array('multiLang'=>1, 'showInList'=>0)),
            new Field("text","Текст",2, array('multiLang'=>1)),
//            new Field("h2","Заголовок H2",1, array('multiLang'=>1, 'showInList'=>0)),
//            new Field("robots","robots",1, array('multiLang'=>1, 'showInList'=>1)),
        );
    }

    /*function afterAdd($row) {
        YandexTranslate($row, $this->TABLE);
    }

    function afterEdit($row){
        YandexTranslate($row, $this->TABLE);
    }*/
}