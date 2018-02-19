<?php
//	Просмотр переменной
function view($data)
{
	echo '<pre>'.print_r($data, TRUE).'</pre>';
}

include(ADM_ROOT.'/inc/ExcelClass.php');

$action = 'export';
if (isset($_GET['action']) && $_GET['action'] == 'import')
{
	$action = 'import';
}

$excel = new Excel();

if ($action == 'import')
{
	echo '<form method="post" enctype="multipart/form-data">';
	echo '<p><h2>Excel импорт</h2></p>';
	echo '<p>Файл импорта в CSV формате: <input type="file" name="csv" style="display:inline; margin-left:20px;" /></p>';
	echo '<p><input type="submit" value="Загрузить файл" name="make" /></p>';
	echo '</form>';

	$fname = ADM_ROOT.'/tmp/import-'.date('Y-m-d').'.csv';

	if (isset($_FILES['csv']) && $_FILES['csv']['error'] == 0 && $_FILES['csv']['size'] > 0)
	{
		copy($_FILES['csv']['tmp_name'], $fname);

        //  Допустимые поля
        $possible_fields = $excel->get_exists_fields();

		$csv = fopen($fname, 'r');
		$fields = str_getcsv(fgets($csv), ';');

		if (count($fields) > 1 && (in_array('id', $fields) || in_array('articul', $fields)))
		{
			$excel->create_import_table($fields);

			$ins = [];
			while (TRUE)
			{
				$eof = feof($csv);

				$row = str_getcsv(fgets($csv), ';');
				$item = [];
				foreach ($fields as $pos => $name)
				{
                    if (isset($possible_fields[$name]))
                    {
                        if (!isset($row[$pos]))
                        {
                            $row[$pos] = '';
                        }
                        //  Даты преобразуются в системный формат
                        if (isset($possible_fields[$name]['format']) && $possible_fields[$name]['format'] == 'date')
                        {
                            $dt = explode('.', $row[$pos]);
                            if (count($dt) == 3 && checkdate($dt[1], $dt[0], $dt[2]))
                            {
                                $row[$pos] = $dt[2].'-'.$dt[1].'-'.$dt[0];
                            }
                        }
                        $item[] = pdoEscape(iconv('cp1251', 'UTF-8', $row[$pos]));
                    }
				}
				if (strlen(trim($item[0])) > 2)
				{
					$ins[] = "(".implode(", ", $item).")";
				}
				if (count($ins) >= 100 || $eof)
				{
					$q = "INSERT IGNORE INTO `import_products` (".implode(', ', $fields).") VALUES ".implode(', ', $ins);
					pdoExec($q);
					$ins = [];
				}

				if ($eof)
				{
					break;
				}
			}

			fclose($csv);

			foreach (['move', 'offset', 'selected_fields'] as $f)
			{
				if (isset($_SESSION[$f]))
				{
					unset($_SESSION[$f]);
				}
			}

			//	Перенос товаров и параметров в основную таблицу
			$excel->move_products($fields);
		}
		else
		{
			echo '<p>Файл должен содержать колонку "id" или "articul"</p>';
		}
	}
	elseif (isset($_SESSION['move']))
	{
		//	Перенос товаров и параметров в основную таблицу
		$excel->move_products($_SESSION['selected_fields']);
	}
}
else
{
	echo '<form method="post">';
	echo '<p><h2>Excel экспорт</h2></p>';
	echo '<p><input type="submit" value="Получить файл" name="make" /></p>';
	$fields = $excel->get_exists_fields();
	$categories = $excel->get_exists_categories();

	//	Генерация файла
	if (isset($_POST['make']))
	{
        if (isset($_POST['category']) && is_array($_POST['category']) && count($_POST['category']) && isset($_POST['field']) && is_array($_POST['field']) && count($_POST['field']))
        {
            $fname = '/tmp/export-'.date('Y-m-d').'.csv';
            if (file_exists(ADM_ROOT.$fname))
            {
                unlink(ADM_ROOT.$fname);
            }

            $csv = fopen(ADM_ROOT.$fname, 'w+');
            fputcsv($csv, $_POST['field'], ';');

            $limit = 100;
            $offset = 0;
            while(TRUE)
            {
                $select = [];
                foreach ($_POST['field'] as $f)
                {
                    if (isset($fields[$f]))
                    {
                        if (in_array($fields[$f]['place'], ['product', 'product_info']))
                        {
                            $select[$f] = $fields[$f]['place'].'.`'.$f.'`';
                        }
                        if ($fields[$f]['place'] == 'supplier')
                        {
                            $select[$f] = "supplier.`name` AS `supplier`";
                        }
                        if ($fields[$f]['place'] == 'category')
                        {
                            $select[$f] = "GROUP_CONCAT(category.`category_path` ORDER BY category.`category_path` ASC SEPARATOR ';') AS `category_path`";
                        }
                    }
                }

                $q = "SELECT product.`id`, ".implode(', ', $select)." "
                    ."FROM `catalog_products` product "
                    ."LEFT JOIN `catalog_products_info` product_info ON product_info.`record_id`=product.`id` AND `product_info`.`lang`=1 "
                    ."LEFT JOIN `catalog_products_categories_assoc` ass ON ass.`product_id`=product.`id` "
                    ."LEFT JOIN `catalog_categories` category ON category.`id`=ass.`cat_id` "
                    ."LEFT JOIN `suppliers` supplier ON product.`supplier_id`=supplier.`id` "
                    ."WHERE product.`id` IN(SELECT `product_id` FROM `catalog_products_categories_assoc` WHERE `cat_id` IN(".implode(', ', $_POST['category']).")) "
                    ."GROUP BY product.`id` "
                    ."ORDER BY category.`category_path`, product_info.`name` ASC "
                    ."LIMIT ".$limit." OFFSET ".$offset;
                $res = pdoFetchAll($q, PDO::FETCH_ASSOC);
                if (is_array($res) && count($res))
                {
                    $items = [];

                    foreach ($res as $row)
                    {
                        foreach ($_POST['field'] as $f)
                        {
                            if (isset($row[$f]))
                            {
                                $items[$row['id']][$f] = $excel->format_field($f, $row[$f]);
                            }
                            else
                            {
                                $items[$row['id']][$f] = '';
                            }
                        }
                    }

                    $q = "SELECT value.`product_id`, value.`param_id`, GROUP_CONCAT(value.`value_name_1` ORDER BY value.`value_name_1` ASC SEPARATOR ';') AS `value`, CONCAT('p_', param.`name_alt`) AS `key` "
                        ."FROM `extra_params_cache` value "
                        ."LEFT JOIN `extra_params` param ON param.`id`=value.`param_id` "
                        ."WHERE value.`product_id` IN(".implode(', ', array_keys($items)).")"
                        ."GROUP BY value.`param_id`, value.`product_id` "
                        ."ORDER BY value.`value_name_1`";
                    $res = pdoFetchAll($q, PDO::FETCH_ASSOC);
                    if (is_array($res) && count($res))
                    {
                        foreach ($res as $row)
                        {
                            if (isset($items[$row['product_id']][$row['key']]))
                            {
                                $items[$row['product_id']][$row['key']] = $excel->format_field($row['key'], $row['value']);
                            }
                        }
                    }

                    foreach ($items as $item_id => $item)
                    {
                        if (isset($item['image']))
                        {
                            $item['image'] = [];
                            for ($i = 1; $i <= 10; $i++)
                            {
                                $img = '/images/catalog_products/'.floor($item_id / 1000).'/catalog_products.'.$item_id.'.'.$i.'.b.jpg';
                                if (file_exists(__DIR__.'/../..'.$img))
                                {
                                    $item['image'][] = 'http://'.$_SERVER['HTTP_HOST'].$img;
                                }
                            }
                            $item['image'] = implode('|', $item['image']);
                        }
                        fputcsv($csv, $item, ';');
                    }

                    $offset += $limit;
                }
                else
                {
                    break;
                }
            }

            fclose($csv);

            echo '<p><a href="/admin'.$fname.'" target="_blank">Скачать файл '.$fname.'</a></p>';
        }
        else
        {
            echo '<p style="font-size:18px;color:#F00;">Выберите колонки и категории</p>';
        }
	}

	if (is_array($fields))
	{
		echo '<ul style="float:left; margin:0 40px 0 0; padding:0;">';
		echo '<li><h2>Колонки</h2></li>';
		echo '<li><label><input type="checkbox" onchange="',
			"$(this).closest('ul').find('input[type=checkbox]').prop('checked', $(this).prop('checked')).attr('checked', $(this).attr('checked'))",
			'" /> Выбрать все</label></li>';
		foreach ($fields as $field)
		{
			echo '<li><label><input name="field[',
				$field['key'],
				']" value="',
				$field['key'],
				'" type="checkbox"',
				(isset($_POST['field'][$field['key']])) ? ' checked' : '',
				' /> ',
				'<b style="color:#039">'.$field['key'].'</b> - ',
				$field['name'],
				'</label></li>';
		}
		echo '</ul>';
	}
	if (is_array($categories))
	{
		echo '<ul style="float:left; margin:0; padding:0;">';
		echo '<li><h2>Категории</h2></li>';
		echo '<li><label><input type="checkbox" onchange="',
		"$(this).closest('ul').find('input[type=checkbox]').prop('checked', $(this).prop('checked')).attr('checked', $(this).attr('checked'))",
		'" /> Выбрать все</label></li>';
		foreach ($categories as $name => $id)
		{
			echo '<li><label><input name="category['.$id.']" value="'.$id.'" type="checkbox" '.((isset($_POST['category'][$id])) ? 'checked' : '').' /> '.$name.'</label></li>';
		}
		echo '</ul>';
	}

	echo '</form>';
}