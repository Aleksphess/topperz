<?php
/*
 *  Лоты
 * */

class admin_lots extends AdminTable
{
    public $TABLE           = 'lots';
    public $SORT            = 'id ASC';
    public $IMG_SIZE        = 180; // макс высота 
    public $IMG_VSIZE       = 137; 
    public $IMG_RESIZE_TYPE = 1; //рeсайз по высоте
    public $IMG_BIG_SIZE    = 509 ;
    public $IMG_BIG_VSIZE   = 368;
    public $IMG_NUM         = 10;
    public $ECHO_NAME       = 'name';

    public $FIELD_UNDER     = 'category_id';
    public $NAME            = "Франшиза";
    public $NAME2           = "франшизу";

    public $MULTI_LANG      = 0;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(
            new Field("alias","Алиас",1),
            new Field("name","Заголовок",1),
            
            new Field("category_id","Относится к категории",9, [
                        'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'catalog_categories', 'valsFromCategory'=>-1,
                        'valsEchoField'=>'name']),
            new Field("owner_id","Владелец",9, [
                        'showInList'=>0, 'editInList'=>0, 'valsFromTable'=>'user', 'valsFromCategory'=>null,
                        'valsEchoField'=>'id']),
            new Field("anonce","Анонс",2),
            new Field("text","Текст",2),

            new Field("new","Новый",6,['showInList'=>1,'editInList'=>1]),

            new Field("popular","Популярный",6,['showInList'=>1,'editInList'=>1]),

            new Field("low_cost","Недорогие",6,['showInList'=>1,'editInList'=>1]),

            new Field("views_count","Количество просмотров",1),
            new Field("suggestions_count","Количество предложений (диалогов)",1),
            new Field("begin_date","Дата начала",13),
            new Field("end_date","Дата завершения",13),
            new Field("mark","Количество баллов",1),
            new Field("last_ip","Ip адрес последнего устройства, с которого просматривали лот",1),
            new Field("creation_time","Date of creation",4),
            new Field("update_time","Date of update",4),
            new Field("ph","Обложка бренда(jpg)",11),
            new Field("logo","Логотип бренда(png)",11),
            new Field("mlogo","Логотип бренда(мини, если есть)(png)",11),
            new Field("occupation","Время окупаемости",1),
            new Field("invest","Инвестирование",1),

        );
    }
    
    function afterAdd($row) 
    {
        if (empty($row['alias'])) {
            $qup = "UPDATE ".$this->TABLE." SET alias = '" . Translit($row['name'])."' WHERE id = " . $row['id'];
            pdoExec($qup);
        }
    }
    
    function afterEdit($row) 
    {
        $this->afterAdd($row);
    }
}
