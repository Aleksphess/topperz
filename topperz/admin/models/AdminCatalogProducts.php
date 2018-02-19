<?php

class admin_catalog_categories extends AdminTable
{

    public $TABLE = 'catalog_categories';
    public $IMG_SIZE = 370; // макс высота
    public $IMG_VSIZE = 240;
    public $IMG_RESIZE_TYPE = 5; //рeсайз по высоте
    public $IMG_BIG_SIZE = 47 ;
    public $IMG_BIG_VSIZE = 87;
    public $IMG_NUM = 1;
    public $ECHO_NAME = 'title';
    public $SORT = 'sort DESC';
    public $RUBS_NO_UNDER = 1;
    public $FIELD_UNDER = 'category_id';
    public $IMG_TYPE = 'png';
    public $NAME = "Категории товаров";
    public $NAME2 = "категорию";

    public $MULTI_LANG = 1;

    function __construct()
    {
        $this->fld[] = new Field("title","Заголовок",1, array('multiLang'=>1));
        $this->fld[] = new Field("text","Описание категоии",2, array('multiLang'=>1));
        $this->fld[] = new Field("alias","Alias (генерируеться, если не заполнен)",1);
        $this->fld[] = new Field("bottom","Вывести внизу",6,['showInList'=>1,'editInList'=>1]);
        $this->fld[] = new Field("active","Активна",6,array('showInList'=>1, 'editInList'=>1));
        $this->fld[] = new Field("category_id","Относится к категории",9, [
            'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_categories', 'valsFromCategory'=>-1,
            'valsEchoField'=>'title']);
        $this->fld[] = new Field("sort","SORT",4);
        $this->fld[] = new Field("creation_time","Date of creation",4);
        $this->fld[] = new Field("update_time","Date of update",4);
    }

    function afterAdd($row) {

        if (empty($row['alias'])) {
            $qup = "UPDATE " . $this->TABLE . " SET alias = '" . Translit($row['title_1'])."' WHERE id = "
                . $row['id'];
            pdoExec($qup);
        }
        YandexTranslate($row, $this->TABLE);


    }

    function afterEdit($row)
    {
        $this->afterAdd($row);
    }
}
class admin_catalog_products extends AdminTable
{
    public $TABLE           = 'catalog_products';
    public $SORT            = 'id ASC';
    public $IMG_SIZE        = 180; // макс высота
    public $IMG_VSIZE       = 137;
    public $IMG_RESIZE_TYPE = 1; //рeсайз по высоте
    public $IMG_BIG_SIZE    = 280 ;
    public $IMG_BIG_VSIZE   = 300;
    public $IMG_NUM         = 10;
    public $ECHO_NAME       = 'title';
    public $IMG_TYPE        = 'jpg';
    public $RUBS_NO_UNDER   = 1;

    public $FIELD_UNDER     = 'category_id';
    public $NAME            = "Товар";
    public $NAME2           = "товара";

    public $MULTI_LANG = 1;


    function __construct()
    {
        $this->fld=array(
            new Field("alias","Алиас",1),
            new Field("category_id","Относится к категории",9, [
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_categories', 'valsFromCategory'=>-1,
                'valsEchoField'=>'title']),
            new Field("type","Категория для пицц",10, array('showInList'=>1, 'values'=>['classic', 'proprietary'])),
            /*new Field("product_id","Оставить не заполненым",9, [
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_products', 'valsFromCategory'=>-1,
                'valsEchoField'=>'title']),*/
            new Field("title","Заголовок",1, array('multiLang'=>1)),
            new Field("text","Текст",2, array('multiLang'=>1)),
            new Field("label_id","Лейбл",9, [
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_label',
                'valsEchoField'=>'title']),
            new Field("price","Цена по умолчанию",1),
            new Field("assoc","составы ",4),
            new Field("assoc_topic","топики",4),
            new Field("also_ids","Товары, которые рекомендуются покупать вместе с данным
             (ID товаров через запятую, пример: 545,567)",1),
            new Field("sort","SORT",4),
            new Field("creation_time","Date of creation",4),
            new Field("update_time","Date of update",4),

    );
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

    function show_assoc_topic($row)
    {
        if (empty($row['id'])) {
            $row['id'] = rand(100000,999999);
        }
        return genAssocBlock(['name' => 'Топики', 'id' => $row['id'], 'tableRubsAssoc' => 'topic_products_assoc']);
    }

    function show_assoc($row)
    {
        if (empty($row['id'])) {
            $row['id'] = rand(100000,999999);
        }
        return genAssocBlock(['name' => 'Состав', 'id' => $row['id'], 'tableRubsAssoc' => 'consist_products_assoc']);
    }
}

class admin_consist_products_assoc
{
    public $tableRubs   = 'catalog_consist';
    public $tableItems  = 'catalog_products';
    public $colUnder    = 'consist_id';
    public $colRecord   = 'product_id';
};
class admin_topic_products_assoc
{
    public $tableRubs   = 'catalog_topic';
    public $tableItems  = 'catalog_products';
    public $colUnder    = 'topic_id';
    public $colRecord   = 'product_id';
};
class admin_catalog_params extends AdminTable
{
    public $TABLE           = 'catalog_params';
    public $SORT            = 'id ASC';
    public $IMG_SIZE        = 180; // макс высота
    public $IMG_VSIZE       = 137;
    public $IMG_RESIZE_TYPE = 1; //рeсайз по высоте
    public $IMG_BIG_SIZE    = 509 ;
    public $IMG_BIG_VSIZE   = 368;
    public $IMG_NUM         = 0;
    public $ECHO_NAME       = 'value';

    public $FIELD_UNDER     = 'product_id';
    public $NAME            = "Характеристики";
    public $NAME2           = "Характеристику";

    public $MULTI_LANG = 1;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(

            new Field("product_id","Относится к категории",9, [
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_products',
                'valsEchoField'=>'title']),
            new Field("value","Значение",1),
            new Field("type","Тип(л,см)",1, array('multiLang'=>1)),
            new Field("weight","Вес",1),
            new Field("price","Цена",1),
            new Field("sort","SORT",4),
            new Field("creation_time","Date of creation",4),
            new Field("update_time","Date of update",4),



        );
    }

    function afterAdd($row)
    {
        YandexTranslate($row, $this->TABLE);
    }

    function afterEdit($row)
    {
        $this->afterAdd($row);
    }
}
class admin_catalog_consist extends AdminTable
{
    public $TABLE           = 'catalog_consist';
    public $SORT            = 'id ASC';
    public $IMG_SIZE        = 180; // макс высота
    public $IMG_VSIZE       = 137;
    public $IMG_RESIZE_TYPE = 1; //рeсайз по высоте
    public $IMG_BIG_SIZE    = 58 ;
    public $IMG_BIG_VSIZE   = 58;
    public $IMG_NUM         = 1;
    public $ECHO_NAME       = 'title';
    public $IMG_TYPE        = 'png';
    public $FIELD_UNDER     = 'product_id';
    public $NAME            = "Ингридиент состава";
    public $NAME2           = "ингридиент состава";

    public $MULTI_LANG = 1;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(
            /*new Field("product_id","Относится к категории",9, [
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_products',
                'valsEchoField'=>'title']),*/
            new Field("title","Название",1, array('multiLang'=>1)),
            new Field("sort","SORT",4),
            new Field("creation_time","Date of creation",4),
            new Field("update_time","Date of update",4),
        );
    }



    function afterAdd($row)
    {
        YandexTranslate($row, $this->TABLE);
    }

    function afterEdit($row)
    {
        $this->afterAdd($row);
    }
}
class admin_catalog_topic extends AdminTable
{
    public $TABLE           = 'catalog_topic';
    public $SORT            = 'id ASC';
    public $IMG_SIZE        = 180; // макс высота
    public $IMG_VSIZE       = 137;
    public $IMG_RESIZE_TYPE = 1; //рeсайз по высоте
    public $IMG_BIG_SIZE    = 60 ;
    public $IMG_BIG_VSIZE   = 47;
    public $IMG_NUM         = 1;
    public $ECHO_NAME       = 'title';
    public $IMG_TYPE        = 'png';
    public $FIELD_UNDER     = 'product_id';
    public $NAME            = "Топик";
    public $NAME2           = "ингридиент состава";

    public $MULTI_LANG = 1;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(
            new Field("product_id","Относится к категории",9, [
                'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_products',
                'valsEchoField'=>'title']),
            new Field("title","Название",1, array('multiLang'=>1)),
            new Field("price","Цена за 1 топик",1 ),
            new Field("sort","SORT",4),
            new Field("creation_time","Date of creation",4),
            new Field("update_time","Date of update",4),
        );
    }



    function afterAdd($row)
    {
        YandexTranslate($row, $this->TABLE);
    }

    function afterEdit($row)
    {
        $this->afterAdd($row);
    }
}

class admin_catalog_label extends AdminTable
{
    public $TABLE           = 'catalog_label';
    public $SORT            = 'id ASC';

    public $IMG_NUM         = 0;
    public $ECHO_NAME       = 'title';
    public $NAME            = "Лейблы";
    public $NAME2           = "лейбл";

    public $MULTI_LANG = 1;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(

            new Field("title","Название",1, array('multiLang'=>1)),
            new Field("alias","alias",1 ),
            new Field("sort","SORT",4),
            new Field("creation_time","Date of creation",4),
            new Field("update_time","Date of update",4),
        );
    }



    function afterAdd($row)
    {
        YandexTranslate($row, $this->TABLE);
    }

    function afterEdit($row)
    {
        $this->afterAdd($row);
    }
}


