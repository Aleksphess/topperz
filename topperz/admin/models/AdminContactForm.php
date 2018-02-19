<?php
/*
 *  Контактная форма
 * */

class admin_contact_form extends AdminTable
{
    public $TABLE           = 'contact_form';
    public $SORT            = 'creation_time DESC, is_processed ASC';
    public $IMG_SIZE        = 409;
    public $IMG_VSIZE       = 300;
    public $IMG_RESIZE_TYPE = 5;
    public $IMG_BIG_SIZE    = 800;
    public $IMG_BIG_VSIZE   = 500;
    public $IMG_NUM         = 0;
    public $ECHO_NAME       = 'name';

    public $RUBS_NO_UNDER   = 1;
    public $NAME            = "Формы обратной связи";
    public $NAME2           = "форму";

    public $MULTI_LANG      = 0;
    public $USE_TAGS        = 0;

    function __construct()
    {
        $this->fld=array(
            new Field("name","Имя пользователя",1),
            new Field("is_processed","Обработано",6),
            new Field("phone","Телефон",1, ['showInList' => 1, 'editInList'=>0]),
            new Field("email","Email",1, ['showInList' => 1, 'editInList'=>0]),
            new Field("text","Текст",2, ['showInList' => 0, 'editInList'=>0]),
            new Field("creation_time","Date of creation",4),
        );
    }
    
//    function afterAdd($row) 
//    {
//        if (empty($row['alias'])) 
//        {
//            if (!empty($row['parent_id'])) 
//            {
//                $rowu = FetchID('pages', $row['parent_id']);
//                $parentAlias = $rowu['alias'] . '-';
//            } else {
//                $parentAlias = '';
//            }
//
//            $qup = "UPDATE pages SET alias = '" . Translit($parentAlias . $row['name_1'])."' WHERE id = " . $row['id'];
//            pdoExec($qup);
//        }
//    }
//    
//    function afterEdit($row) {
//        $this->afterAdd($row);
//    }
}