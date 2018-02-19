<?php
/*
 *  Заказы
 * */

class admin_orders extends AdminTable
{
    public $SORT        = 'status_id ASC, creation_time DESC';
    public $NAME        = "Заказы";
    public $NAME2       = "заказ";
    public $IMG_NUM     = 0;
    public $ECHO_NAME   = "creation_time";
    public $TABLE       = 'orders';
    function __construct() {
        $this->fld[] = new Field("creation_time","Дата и время заказа",1);
        $this->fld[] = new Field("name","Имя", 1, ['showInList'=>true]);
        $this->fld[] = new Field("email","Email", 1, ['showInList'=>true]);
        $this->fld[] = new Field("phone","Телефон", 1, ['showInList'=>true]);
        $this->fld[] = new Field("address","Адрес доставки", 1);
        $this->fld[] = new Field("comment","Коментарий к заказу", 7);
        $this->fld[] = new Field("items","В заказе", 5, ['showInList'=>true]);

        $this->fld[] = new Field("total","Сумма, грн.", 4);
        $this->fld[] = new Field("user_id","Пользователь",9, array(
            'showInList'=>1, 'editInList'=>0, 'valsFromTable'=>'user','valsEchoField'=>'username'));
        $this->fld[] = new Field("delivery_id","Доставка",9, array(
            'showInList'=>1, 'editInList'=>0, 'valsFromTable'=>'orders_params', 'valsFromCategory'=>'delivery',
            'valsEchoField'=>'name'));
        $this->fld[] = new Field("pay_id","Тип оплаты",9, array(
            'showInList'=>1, 'editInList'=>0, 'valsFromTable'=>'orders_params', 'valsFromCategory'=>'payment',
            'valsEchoField'=>'name'));
        $this->fld[] = new Field("status_id","Статус",9, array(
            'showInList'=>1, 'editInList'=>0, 'valsFromTable'=>'orders_params', 'valsFromCategory'=>'status',
            'valsEchoField'=>'name'));
        $this->fld[] = new Field("update_time","Date of update",4);

    }

    function pre_Table() {
        return '<div align="right"><strong><span aria-hidden="true" class="glyphicon glyphicon-floppy-save"></span> <a style="" href="export/get_requests_xls.php?table='.$this->TABLE.'" target="_blank">экспорт всех в Excel</a></strong></div>';
    }

    function show_creation_time($row)
    {
        return date("d.m.Y H:i" , $row['creation_time']);
    }



    function afterAjaxUpdate($id, $field, $value) {
        $this->reEvaluate($id);
    }

//    function increaseOrderProducts($orderId) {
//        $products = $this->getProducts($orderId);
//
//        foreach ($products as $product) {
//            $q = "UPDATE catalog_products SET ordered = ordered + " . $product['qty'] . " WHERE id = " . $product['id'];
//            pdoExec($q);
//        }
//    }
//    function decreaseOrderProducts($orderId) {
//        $products = $this->getProducts($orderId);
//
//        foreach ($products as $product) {
//            $q = "UPDATE catalog_products SET ordered = ordered - " . $product['qty'] . " WHERE id = " . $product['id'];
//            pdoExec($q);
//        }
//    }

    function beforeEdit($row) {
//        if ($row['status_id'] != 5 && $_POST['status_id'] == 5) {
//            $this->increaseOrderProducts($row['id']);
//        }
//        elseif ($row['status_id'] == 5 && $_POST['status_id'] != 5) {
//            $this->decreaseOrderProducts($row['id']);
//        }
    }

    function increaseOrderProducts($orderId) {
        $products = $this->getProducts($orderId);

        foreach ($products as $product) {
            $q = "UPDATE catalog_products SET ordered = ordered + " . $product['qty'] . " WHERE id = " . $product['id'];
            pdoExec($q);
        }
    }

    function decreaseOrderProducts($orderId) {
        $products = $this->getProducts($orderId);

        foreach ($products as $product) {
            $q = "UPDATE catalog_products SET ordered = ordered - " . $product['qty'] . " WHERE id = " . $product['id'];
            pdoExec($q);
        }
    }

    function getProducts($orderId) {
        $q = "SELECT "
            . "oi.`product_id` AS `id`, "
            . "oi.`id` AS `assoc_id`, "
            . "oi.`name` AS `name`, "
            . "oi.`price` AS `price`, "
            . "oi.`price_full` AS `price_r`, "
            . "oi.`count` AS `qty`, "
//            . "oi.`installation` AS `installation`, "
            . "oi.`url` AS `url` "
//            . "p.installation as prod_install "
            . "FROM `orders_items` oi "
            . "LEFT JOIN catalog_products p ON (p.id = oi.product_id)"
            . "WHERE oi.`order_id` = " . $orderId;

        $res = pdoFetchAll($q);
        return $res;

    }
    function getSaledProducts($params) {
        $q = "SELECT "
            . "oi.`product_id` AS `product_id`, "
            . "p.`articul` AS `name`, "
            . "SUM(oi.`price` * oi.`count`) AS `sum`, "
            . "SUM(oi.`count`) AS `num` "
            . "FROM `orders_items` oi "
            . "LEFT JOIN catalog_products p ON (p.id = oi.product_id)"
            . "LEFT JOIN orders o ON (o.id = oi.order_id)"
            . "WHERE (o.`creation_time` BETWEEN '" . $params['date1'] . "' AND '" . $params['date2'] ."') "
            . "GROUP by oi.product_id ORDER by sum DESC";

        $res = pdoFetchAll($q);

        return $res;

    }

    function getOrder($orderId) {
        $order = FetchID('orders', $orderId);
        return $order;
    }
    function reEvaluate($orderId) {
//        $order = $this->getOrder($orderId);
        $res = $this->getProducts($orderId);

//        $insVal = FetchID('slovar', 9);
//        $install_base = $insVal['value_1'];
//        $install = 0;
        $total = 0;
        foreach ($res as $item) {
//            $install += $item['qty'] * $item['installation'];
            $subtotal = $item['qty'] * $item['price'];
            pdoExec("UPDATE orders_items SET price_full = " . $subtotal . " WHERE id = " . $item['assoc_id']);
            $total += $subtotal;

        }

//        if ($install > 0) {
//            $total += $install + $install_base;
//        }
        pdoExec("UPDATE orders SET total = " . $total . " WHERE id = " . $orderId);

        return $total;
    }

    function showit_items($row) {

        $res = $this->getProducts($row['id']);
        if ($res)
        {
            $items = '<table class="table-hover">';
            $items.= '<tr style="font-weight:bold;background-color:#EEE"><td align=left style="padding:2px;">Товар</td><td style="padding:2px;">Id</td><td style="padding:2px;">Кол-во</td><td style="padding:2px;">Цена, за шт</td><td style="padding:2px;">Всего</td></tr>';
            foreach ($res as $item)
            {
                $items .= '<tr valign="top"><td width="280"><a href="'.$item['url'] . '" target="_blank">';
                if ($item['id'] > 0) {

                    $items .= $item['name'];
                }
                $items .= "</a></td><td>{$item['id']}</td>";
                $items .= '<td align="center">'.$item['qty'].'</td>';
                $items .= '<td>&nbsp;'.$item['price'].'&nbsp;грн</td> <td> '. $item['qty']*$item['price']  .' грн</td></tr>';
            }
            $items .= '</table>';
            return '<div style="text-align:left;width:600px;margin-bottom:3px;">'.$items.'</div>';
        }

    }

    function show_items($row) {
        $res = "<script language=\"JavaScript\" type=\"text/javascript\">
    function listOrder(orderId,add,del)
    {
            if (add == 1) {
                var addArt = $('#addArt').val();
            } else {
                var addArt = 0;
            }
            
            $.ajax({
              type: \"GET\",
              url: 'ajax/list_order.php',
              data: 'orderId='+orderId+'&addArt='+addArt+'&del='+del+'&jfname=listOrder&xr='+Math.random(),
              success: function(answer) {
              $('#div_items').html(answer);
              $('.switcher').checkboxpicker();
              }
             });
    }
    
    function setInstall(id) {
    
        if ($('#ins_'+id).is(':checked') ) {
            var value = $('#pins_'+id).val();
            if (value == 0) 
                value = 20;
        } else {
            //alert('NO!');
            var value = 0;
        }
        
        $.ajax({
                  type: \"GET\",
                  url: 'ajax/update.php',
                  data: 'table=orders_items&field=installation&value='+value+'&id='+id+'&xr='+Math.random(),
                  success: function(answer) {
                  //$('#div_items').html(answer);
                  
                  }
                 });
        
}
				</script>";
        $res .= '<div id="div_items" style="width:900px;padding-top:10px;">
						<script language="javascript">listOrder('.$row['id'].');</script>
					</div>';
        return $res;
    }

    function addProduct($orderId, $articul) {
        if (!empty($articul)) {

            $q = "SELECT * FROM catalog_products WHERE articul LIKE '" . $articul . "'";

            $rowp = pdoFetchAll($q);
            $rowp = $rowp[0];

            $qi="INSERT INTO orders_items (`id`,`order_id`,`product_id`,`name`,`count`,`url`,`price`,`price_full`) "
                . "VALUES (NULL , ".$orderId.", ".$rowp['id'].", '".$rowp['alias']."', '1', '/catalog/cat/".$rowp['alias']."/post/".$rowp['id']."',".$rowp['price'].",".$rowp['price']."); ";
            pdoExec($qi);
            //echo $qi;
        }
    }
    function removeProduct($orderId, $id) {
        if (!empty($id)) {
            $qi="DELETE FROM orders_items WHERE order_id = " . $orderId . " AND id = " . $id;
            pdoExec($qi);
        }
    }

    function getOrders($where) {

        $q = "SELECT * FROM orders WHERE $where";
        $rows = pdoFetchAll($q);
        return $rows;

    }

    function showOrdersWidget($where) {

        $orders = $this->getOrders($where);
        ?>
        <table class="table">
            <thead>

            <th >Дата заказа</td>
            <th >Товары</td>


            </thead>
            <?php
            foreach ($orders as $row) {

                echo '<tr>
			<td><a href="items.php?tabler=&tablei=orders&srci=items.php&id='.$row['id'].'#header">'.date("d.m.Y H:i" , $row['creation_time']).'</a></td>
			<td>'.$this->showit_items($row).'</td>
			<td></td>
			</tr>';
            }
            ?>
        </table>
        <?php

    }
}
class admin_orders_items extends AdminTable
{
    public $SORT        = 'o_id';
    public $name        = "Список в заказе";
    public $NAME2       = "в заказ";
    public $IMG_NUM     = 0;
    public $ECHO_NAME   = "p_name";

    function __construct()
    {
        $this->fld[] = new Field("o_id","ИД заказа", 0);
        $this->fld[] = new Field("p_id","ИД товара", 0);
        $this->fld[] = new Field("p_base_id","ИД товара базовый", 0);
        $this->fld[] = new Field("p_name","Название товара", 1);
        $this->fld[] = new Field("p_price","Цена товара", 0);
        $this->fld[] = new Field("p_count","Количество товара", 0);
        $this->fld[] = new Field("p_url","URL", 1);
    }

    function afterAjaxUpdate($id, $field, $value) {
        $row = FetchID('orders_items', $id);
        $order = new admin_orders();
        $order->reEvaluate($row['order_id']);
    }

}
class admin_orders_params extends AdminTable
{
    public $SORT        = '`type` ASC, `id` ASC';
    public $name        = 'Параметры заказов';
    public $ECHO_NAME   = 'name';
    public $FIELD_UNDER = 'type';

    function __construct()
    {
        $this->fld = array(
            new Field("name", "Название", 1),
            new Field("type", "Тип значения", 4, ['showInList' => true]),
            new Field("add_cost", "Добавочная стоимость, грн", 0, ['showInList' => true]),
            new Field("sort","Порядковый номер при cортировке",4)
        );
    }

    function show_type($row)
    {
        $types = array(
            'delivery' => 'Доставка',
            'payment' => 'Оплата',
            'status' => 'Статус'
        );
        if (!isset($_REQUEST['id']))
        {
            $sel = $types[$row['type']];
        }
        else
        {
            $sel = '<div><p class="txt"><b>Тип значения</b><br></p><select id="type" name="type">';
            foreach ($types as $type => $name)
            {
                $sel .= '<option value="'.$type.'"'.(($row['type'] == $type)?' selected':'').'>'.$name.'</option>';
            }
            $sel .= '</select><br /><br /></div>';
        }
        return $sel;
    }
}