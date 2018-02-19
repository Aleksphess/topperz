<?php
class Excel
{
	private $fields = NULL;

	//	Возвращает список доступных для импорта/экспорта колонок
	public function get_exists_fields($place = NULL)
	{
		if (!$this->fields)
		{
			$this->fields = [
                'id' => [
                    'name' => 'Артикул (обязательный)',
                    'key' => 'id',
                    'place' => 'product',
                    'format' => 'int'
                ],
				'articul' => [
					'name' => 'Артикул (обязательный)',
					'key' => 'articul',
					'place' => 'product',
					'format' => 'short_string'
				],
				'category_path' => [
					'name' => 'Категория размещения',
					'key' => 'category_path',
					'place' => 'category',
					'format' => 'string',
					'table_field' => 'cat_id'
				],
				'name' => [
					'name' => 'Название',
					'key' => 'name',
					'place' => 'product_info',
					'format' => 'string'
				],
                'name_alt' => [
                    'name' => 'Альтернативное название для сео-текстов',
                    'key' => 'name_alt',
                    'place' => 'product_info',
                    'format' => 'string'
                ],
				'txt' => [
					'name' => 'Описание',
					'key' => 'txt',
					'place' => 'product_info',
					'format' => 'text'
				],
                'supplier' => [
                    'name' => 'Поставщик',
                    'key' => 'supplier',
                    'place' => 'supplier',
                    'format' => 'string',
                    'table_field' => 'supplier_id'
                ],
                'brand' => [
                    'name' => 'Бренд',
                    'key' => 'brand',
                    'place' => 'product',
                    'format' => 'short_string'
                ],
				'price' => [
					'name' => 'Цена розничная',
					'key' => 'price',
					'place' => 'product',
					'format' => 'float'
				],
				'price_min' => [
					'name' => 'Максимальная цена для зарегистрированного пользователя',
					'key' => 'price_min',
					'place' => 'product',
					'format' => 'float'
				],
				'price_max' => [
					'name' => 'Минимальная цена для зарегистрированного пользователя',
					'key' => 'price_max',
					'place' => 'product',
					'format' => 'float'
				],
                'price_input' => [
                    'name' => 'Цена входящая',
                    'key' => 'price_input',
                    'place' => 'product',
                    'format' => 'float'
                ],
                'price_whole' => [
                    'name' => 'Цена оптовая',
                    'key' => 'price_whole',
                    'place' => 'product',
                    'format' => 'float'
                ],
                'available' => [
                    'name' => 'Количество на складе',
                    'key' => 'available',
                    'place' => 'product',
                    'format' => 'int'
                ],
                'avail_text' => [
                    'name' => 'Наличие на складе текстом',
                    'key' => 'avail_text',
                    'place' => 'product',
                    'format' => 'short_string'
                ],
				'discount_formula' => [
					'name' => 'Формула для расчёта постоянной скидки',
					'key' => 'discount_formula',
					'place' => 'product',
					'format' => 'short_string'
				],
                'discount_end_date' => [
                    'name' => 'Дата окончания действия скидки',
                    'key' => 'discount_end_date',
                    'place' => 'product',
                    'format' => 'date'
                ],
				'hide' => [
					'name' => 'Скрыть товар в каталоге',
					'key' => 'hide',
					'place' => 'product',
					'format' => 'int'
				],
				'recom' => [
					'name' => 'Рекомендуемый товар',
					'key' => 'recom',
					'place' => 'product',
					'format' => 'int'
				],
                'flag' => [
                    'name' => 'Флаг',
                    'key' => 'flag',
                    'place' => 'product',
                    'format' => 'int'
                ],
                'to_xml' => [
                    'name' => 'Выгружать в XML',
                    'key' => 'to_xml',
                    'place' => 'product',
                    'format' => 'int'
                ],
				'installation' => [
					'name' => 'Стоимость электромонтажа',
					'key' => 'installation',
					'place' => 'product',
					'format' => 'float'
				],
				'gift_articul' => [
					'name' => 'Артикул товара в подарок',
					'key' => 'gift_articul',
					'place' => 'product',
					'format' => 'short_string'
				],
				'gift_end_date' => [
					'name' => 'Дата завершения акции "Подарок"',
					'key' => 'gift_end_date',
					'place' => 'product',
					'format' => 'date'
				],
                'image' => [
                    'name' => 'Ссылки на фотографию товара',
                    'key' => 'image',
                    'place' => 'image',
                    'format' => 'string'
                ],
                'admin' => [
                    'name' => 'Логин админа для редактирования',
                    'key' => 'admin',
                    'place' => 'product',
                    'format' => 'short_string'
                ],

                //-----

                'context' => [
                    'name' => 'Контекст',
                    'key' => 'context',
                    'place' => 'product',
                    'format' => 'float'
                ],
                'context_brand' => [
                    'name' => 'Контекст с брендом',
                    'key' => 'context_brand',
                    'place' => 'product',
                    'format' => 'float'
                ],
                'amount_whole' => [
                    'name' => 'Количество для опта',
                    'key' => 'amount_whole',
                    'place' => 'product',
                    'format' => 'int'
                ],
                'amount_pack' => [
                    'name' => 'Количество в упаковке',
                    'key' => 'amount_pack',
                    'place' => 'product',
                    'format' => 'int'
                ],
                'rate' => [
                    'name' => 'Курс валюты',
                    'key' => 'rate',
                    'place' => 'product',
                    'format' => 'float'
                ],
                'k1' => [
                    'name' => 'Коэффициент К1',
                    'key' => 'k1',
                    'place' => 'product',
                    'format' => 'float'
                ],
                'k2' => [
                    'name' => 'Коэффициент К2',
                    'key' => 'k2',
                    'place' => 'product',
                    'format' => 'float'
                ],
			];

			$q = "SELECT `id`, `name_1` AS `name`, CONCAT('p_', `name_alt`) AS `key` "
				."FROM `extra_params` "
				."WHERE LENGTH(`name_alt`)>0";
			$res = pdoFetchAll($q);
			if (is_array($res))
			{
				foreach ($res as $row)
				{
					$this->fields[$row['key']] = [
						'name' => 'Параметр: '.$row['name'],
						'key' => $row['key'],
						'place' => 'param',
						'format' => 'string',
						'table_field' => preg_replace('#^p_#', '', $row['key']),
						'table_id' => $row['id']
					];
				}
			}
		}

		$fields = [];

		if (is_array($place) && count($place))
		{
			foreach ($this->fields as $col)
			{
				if (in_array($col['place'], $place))
				{
					$fields[$col['key']] = $col;
				}
			}
		}
		else
		{
			$fields = $this->fields;
		}

		return $fields;
	}

	public function get_exists_categories()
	{
		$this->update_categories_path();

        $categories = [];

		$q = "SELECT `id`, `category_path` AS `name` "
			."FROM `catalog_categories` "
			."WHERE LENGTH(`category_path`)>0 "
			."ORDER BY `category_path` ASC";
		$res = pdoFetchAll($q);
        if ($res)
        {
            foreach ($res as $row)
            {
                $categories[$row['name']] = $row['id'];
            }
        }

		return $categories;
	}

    public function get_exists_suppliers()
    {
        $suppliers = [];

        $q = "SELECT `id`, `name` "
            ."FROM `suppliers`";
        $res = pdoFetchAll($q);
        if ($res)
        {
            foreach ($res as $row)
            {
                $suppliers[$row['name']] = $row['id'];
            }
        }

        return $suppliers;
    }

    /*
     * Метод преобразует значение поля в соответствии с указанным в коллекции типом.
     * Используется для подготовки данных к записи в CSV файл
     */
	public function format_field($field, $value)
	{
		$fields = $this->get_exists_fields();
		if (isset($fields[$field]))
		{
			if (!isset($fields[$field]['format']))
			{
				if ((string)((float)$value) == rtrim($value, '0'))
				{
					$fields[$field]['format'] = 'float';
				}
				else
				{
					$fields[$field]['format'] = 'string';
				}
			}
			switch ($fields[$field]['format'])
			{
				case 'int':
					$value = (int)$value;
					break;
				case 'float':
					$value = (float)$value;
					$value = str_replace('.', ',', (string)$value);
					break;
                case 'date':
                    $value = explode('-', $value);
                    $value = array_reverse($value);
                    $value = implode('.', $value);
                    break;
				case 'text':
					$value = preg_replace('(\s+)', ' ', $value);
					$value = iconv('UTF-8', 'cp1251//IGNORE', $value);
					break;
				case 'string':
                case 'short_string':
					$value = iconv('UTF-8', 'cp1251//IGNORE', $value);
					break;
			}
		}
		return $value;
	}

	public function create_import_table($selected_fields)
	{
		$fields = $this->get_exists_fields();

		//	Удаляю таблицу импорта товаров
		$q = "DROP TABLE `import_products`";
		pdoExec($q);

		$q = "CREATE TABLE IF NOT EXISTS `import_products` ( "
			."`import_id` int(11) NOT NULL AUTO_INCREMENT, ";
		foreach ($fields as $field)
		{
			if (in_array($field['key'], $selected_fields))
			{
				$q .= "`".$field['key']."`";
				if (!isset($field['format']))
				{
					$field['format'] = 'string';
				}
				switch ($field['format'])
				{
                    case 'int':
                        $q .= " INT(11), ";
                        break;
					case 'float':
						$q .= " FLOAT, ";
						break;
					case 'text':
						$q .= " TEXT, ";
						break;
					case 'short_string':
						$q .= " VARCHAR(100), ";
						break;
					case 'string':
						$q .= " VARCHAR(256), ";
						break;
                    case 'date':
                        $q .= " DATE, ";
                        break;
					default:
						$q .= " VARCHAR(256), ";
				}
			}
		}
        $key = 'id';
        if (!in_array('id', $selected_fields))
        {
            $key = 'articul';
        }
		$q .= "`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время импорта', "
			. "PRIMARY KEY (`import_id`), "
			. "UNIQUE KEY `".$key."` (`".$key."`) "
			. ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Товары из Excel'";
		pdoExec($q);
	}

	public function update_categories_path()
	{
		//	Формирую названия категорий в виде "Название категории/Название подкатегории/.."
		$q = "UPDATE `catalog_categories` SET `category_path`=''";
		pdoQuery($q);

		$q = "INSERT IGNORE INTO `catalog_categories` (`id`, `category_path`) "
			."SELECT c.`id`, ci.`name` AS `category_path` "
			."FROM `catalog_categories` c "
			."LEFT JOIN `catalog_categories_info` ci ON ci.`record_id`=c.`id` AND ci.`lang`=1 "
			."WHERE c.`parent_id`=-1 "
			."ON DUPLICATE KEY UPDATE `category_path`=VALUES(`category_path`)";
		pdoQuery($q);

		for ($level = 0; $level < 5; $level++)
		{
			$q = "INSERT IGNORE INTO `catalog_categories` (`id`, `category_path`) "
				."SELECT cp.`id`, CONCAT(c.`category_path`, '/', ci.`name`) AS `category_path` "
				."FROM `catalog_categories` c "
				."LEFT JOIN `catalog_categories` cp ON cp.`parent_id`=c.`id` "
				."LEFT JOIN `catalog_categories_info` ci ON ci.`record_id`=cp.`id` AND ci.`lang`=1 "
				."WHERE c.`category_path`!='' AND cp.`category_path`='' "
				."ON DUPLICATE KEY UPDATE `category_path`=VALUES(`category_path`)";
			pdoQuery($q);
		}
	}

	private function get_sql_fields($selected_fields, $place)
	{
		$result = [
			'select' => [],
			'insert' => [],
			'update' => []
		];

		$fields = $this->get_exists_fields($place);
		foreach ($fields as $key => $data)
		{
			if (in_array($key, $selected_fields))
			{
				$result['select'][] = '`'.$key.'`';
				if (!isset($data['table_field']))
				{
					$data['table_field'] = $key;
				}
				$result['insert'][] = '`'.$data['table_field'].'`';
				$result['update'][] = '`'.$data['table_field'].'`=VALUES(`'.$data['table_field'].'`)';
			}
		}

		return $result;
	}

	//	Метод переносит информацию из таблицы импорта в основные таблицы каталога
	public function move_products($selected_fields)
	{
		if (!isset($_SESSION['move']))
		{
			$q = "UPDATE `catalog_products` "
				."SET `import_id`=0";
			pdoQuery($q);
            $q = "DELETE FROM `catalog_products_categories_assoc` "
                ."WHERE `product_id` NOT IN (SELECT `id` FROM `catalog_products`)";
            pdoQuery($q);
            $q = "DELETE FROM `catalog_products_info` "
                ."WHERE `record_id` NOT IN (SELECT `id` FROM `catalog_products`)";
            pdoQuery($q);
            $q = "DELETE FROM `extra_params_products_assoc` "
                ."WHERE `product_id` NOT IN (SELECT `id` FROM `catalog_products`)";
            pdoQuery($q);
            $q = "DELETE FROM `files` "
                ."WHERE `table_name`='catalog_products' AND `record_id` NOT IN (SELECT `id` FROM `catalog_products`)";
            pdoQuery($q);

			if ($this->move_product_data($selected_fields))
			{
				$_SESSION['move'] = 'category';
				$_SESSION['selected_fields'] = $selected_fields;
                echo '<p style="font-size:18px; color:#e22d2d; padding:20px 0;">Ожидайте. Выполняется импорт</p>';
				echo '<meta http-equiv="refresh" content="0;URL=" />';
			}
		}
		else
		{
			switch($_SESSION['move'])
			{
                case 'category':
                    $this->move_product_categories($selected_fields);
                    echo '<p style="font-size:18px; color:#e22d2d; padding:20px 0;">Ожидайте. Выполняется импорт Привязок к категориям</p>';
                    echo '<meta http-equiv="refresh" content="0;URL=" />';
                    break;
                case 'supplier':
                    $this->move_product_supplier($selected_fields);
                    echo '<p style="font-size:18px; color:#e22d2d; padding:20px 0;">Ожидайте. Выполняется импорт Поставщиков</p>';
                    echo '<meta http-equiv="refresh" content="0;URL=" />';
                    break;
				case 'info':
					$this->move_product_info_data($selected_fields);
					echo '<p style="font-size:18px; color:#e22d2d; padding:20px 0;">Ожидайте. Выполняется импорт текстовых данных</p>';
					echo '<meta http-equiv="refresh" content="0;URL=" />';
					break;
				case 'params':
					$this->move_product_params($selected_fields);
					echo '<p style="font-size:18px; color:#e22d2d; padding:20px 0;">Ожидайте. Выполняется импорт характеристик</p>';
					echo '<meta http-equiv="refresh" content="0;URL=" />';
					break;
				case 'files':
					$this->move_product_files($selected_fields);
					echo '<p style="font-size:18px; color:#e22d2d; padding:20px 0;">Ожидайте. Выполняется импорт файлов</p>';
					echo '<meta http-equiv="refresh" content="0;URL=" />';
					break;
				default:
					foreach (['move', 'offset', 'selected_fields'] as $f)
					{
						if (isset($_SESSION[$f]))
						{
							unset($_SESSION[$f]);
						}
					}
					echo '<p style="font-size:18px; color:#060; padding:20px 0;">Готово</p>';
			}
		}
	}

	private function move_product_data($selected_fields)
	{
		$fields = $this->get_sql_fields($selected_fields, ['product']);
		foreach ($fields['select'] as $pos => $field)
		{
			$fields['select'][$pos] = 'i.'.$field;
		}

		if (in_array('`id`', $fields['insert']) || in_array('`articul`', $fields['insert']))
		{
			$q = "INSERT IGNORE INTO `catalog_products` ("
				.PHP_EOL."`import_id`, "
				.PHP_EOL."`base`, "
				.PHP_EOL."`base_id`, "
				.PHP_EOL."`carrency_id`, "
				.PHP_EOL."`also_ids`, "
				.PHP_EOL."`creation_time`, "
				.PHP_EOL."`update_time`, "
				.PHP_EOL.implode(', '.PHP_EOL, $fields['insert'])
				.PHP_EOL.") "
				.PHP_EOL."SELECT "
				.PHP_EOL."i.`import_id`, "
				.PHP_EOL."1 AS `base`, "
				.PHP_EOL."0 AS `base_id`, "
				.PHP_EOL."1 AS `currency_id`, "
				.PHP_EOL."'' AS `also_ids`, "
				.PHP_EOL.time()." AS `creation_time`, "
				.PHP_EOL.time()." AS `update_time`, "
				.PHP_EOL.implode(', '.PHP_EOL, $fields['select'])." "
				.PHP_EOL."FROM `import_products` i "
				.PHP_EOL."ON DUPLICATE KEY UPDATE `import_id`=VALUES(`import_id`), `update_time`=VALUES(`update_time`), ".implode(', ', $fields['update']);
			pdoQuery($q);

            return TRUE;
		}

		return FALSE;
	}

    //  Перенос привязок товаров к категориям
    private function move_product_categories($selected_fields)
    {
        $cat = $this->get_sql_fields($selected_fields, ['category']);
        if (isset($cat['select'][0]) && strlen($cat['select'][0]))
        {
            $q = "DELETE FROM `catalog_products_categories_assoc` "
                ."WHERE `product_id` IN (SELECT `id` FROM `catalg_products` WHERE `import_id`>0)";
            pdoQuery($q);

            $categories = $this->get_exists_categories();

            $limit = 100;
            $step = 0;
            while (TRUE)
            {
                $q = "SELECT p.`id`, i.`category_path` "
                    ."FROM `import_products` i "
                    ."LEFT JOIN `catalog_products` p ON i.`import_id`=p.`import_id` "
                    ."LIMIT ".$limit." OFFSET ".($limit * $step);
                $res = pdoFetchAll($q);
                if ($res)
                {
                    $ins = array();
                    foreach ($res as $row)
                    {
                        foreach (explode(';', $row['category_path']) as $path)
                        {
                            if (isset($categories[$path]))
                            {
                                $ins[] = "(".(int)$row['id'].", ".(int)$categories[$path].")";
                            }
                        }
                    }
                    $q = "INSERT IGNORE INTO `catalog_products_categories_assoc` (`product_id`, `cat_id`) VALUES ".implode(', '.PHP_EOL, $ins);
                    pdoQuery($q);
                }
                else
                {
                    break;
                }
                $step++;
            }

            $q = "INSERT IGNORE INTO `catalog_products` (`id`, `cat_id`) "
                ."SELECT `product_id`, `cat_id` FROM `catalog_products_categories_assoc` "
                ."ON DUPLICATE KEY UPDATE `cat_id`=VALUES(`cat_id`)";
            pdoQuery($q);
        }

        $_SESSION['move'] = 'supplier';
    }

    //  Перенос привязок товаров к категориям
    private function move_product_supplier($selected_fields)
    {
        $sup = $this->get_sql_fields($selected_fields, ['supplier']);
        if (isset($sup['select'][0]) && strlen($sup['select'][0]))
        {
            //  Добавляю новых поставщиков
            $q = "INSERT IGNORE INTO `suppliers` (`name`) "
                ."SELECT `supplier` "
                ."FROM `import_products` "
                ."WHERE LENGTH(`supplier`)>0 "
                ."GROUP BY `supplier`";
            pdoQuery($q);

            //  Проставляю в товары ID поставщиков
            $q = "INSERT IGNORE INTO `catalog_products` (`id`, `supplier_id`) "
                ."SELECT p.`id`, s.`id` AS `supplier_id` "
                ."FROM `import_products` i "
                ."LEFT JOIN `catalog_products` p ON p.`import_id`=i.`import_id` "
                ."LEFT JOIN `suppliers` s ON s.`name`=i.`supplier` "
                ."WHERE LENGTH(i.`supplier`)>0 AND s.`id`>0 "
                ."ON DUPLICATE KEY UPDATE `supplier_id`=VALUES(`supplier_id`)";
            pdoQuery($q);
        }

        $_SESSION['move'] = 'info';
    }

    private function move_product_info_data($selected_fields)
	{
		$fields = $this->get_sql_fields($selected_fields, ['product_info']);

		if (count($fields['select']) > 0)
		{
			$q = "INSERT IGNORE INTO `catalog_products_info` ("
				.PHP_EOL."`record_id`, "
				.PHP_EOL."`lang`,"
				.PHP_EOL.implode(', '.PHP_EOL, $fields['insert'])
				.PHP_EOL.") "
				.PHP_EOL."SELECT "
				.PHP_EOL."p.`id` AS `record_id`, "
				.PHP_EOL."l.`id` AS `lang`, "
				.PHP_EOL."i.".implode(', '.PHP_EOL.'i.', $fields['select'])." "
				.PHP_EOL."FROM `catalog_products` p "
				.PHP_EOL."LEFT JOIN `import_products` i ON i.`import_id`=p.`import_id` "
				.PHP_EOL."CROSS JOIN `lang` l "
				.PHP_EOL."WHERE i.`import_id`>0 "
				.PHP_EOL."ON DUPLICATE KEY UPDATE ".implode(', ', $fields['update']);
			pdoQuery($q);

			//	Добавляю ссылки транслитом для новых товаров
			$step = 0;
			while (TRUE)
			{
				$q = "SELECT p.`id`, i.`name` "
					."FROM `catalog_products` p "
					."LEFT JOIN `catalog_products_info` i ON i.`record_id`=p.`id` "
					."WHERE p.`name_alt`='' "
					."LIMIT 1000";
				$res = pdoFetchAll($q);
				if ($res)
				{
					$upd = array();
					foreach ($res as $row)
					{
						$upd[] = "(".$row['id'].", ".pdoEscape(Translit($row['name'])."-".$row['id']).")";
					}
					$q = "INSERT IGNORE INTO `catalog_products` (`id`, `name_alt`) VALUES "
						.implode(', ', $upd)
						." ON DUPLICATE KEY UPDATE `name_alt`=VALUES(`name_alt`)";
					pdoQuery($q);
				}
				else
				{
					break;
				}
				if ($step > 1000)
				{
					break;
				}
				$step++;
			}
		}

		$_SESSION['move'] = 'params';
	}

	private function move_product_params($selected_fields)
	{
		$tm = microtime(TRUE);

		$param_ids = [];
		$fields = $this->get_exists_fields(['param']);
		foreach ($fields as $key => $field)
		{
			if (in_array($key, $selected_fields))
			{
				$param_ids[] = $field['table_id'];
			}
			else
			{
				unset($fields[$key]);
			}
		}

		if (!isset($_SESSION['offset']))
		{
			//	Удаляю все указанные в файле параметры указанных в файле товаров
			$q = "DELETE FROM `extra_params_products_assoc` "
				."WHERE `param_id` IN(".implode(', ', $param_ids).") "
				."AND `product_id` IN (SELECT `id` FROM `catalog_products` WHERE `import_id`>0)";
			pdoExec($q);

			//	Добавляю новые значения параметров
			$ins = [];
			foreach ($fields as $field)
			{
				$q = "SELECT `".$field['key']."` AS `value` "
					."FROM `import_products` "
					."WHERE LENGTH(`".$field['key']."`)>0 "
					."GROUP BY `".$field['key']."`";
				$values = pdoFetchAll($q, PDO::FETCH_ASSOC);
				if ($values)
				{
					foreach ($values as $value)
					{
						$value = explode(';', $value['value']);
						$value = array_map('trim', $value);
						foreach ($value as $v)
						{
							$ins[] = "(".pdoEscape($v).", ".$field['table_id'].")";
						}
					}
				}
			}
			if (count($ins))
			{
				$q = "INSERT IGNORE INTO `extra_params_values` (`name_1`, `param_id`) VALUES ".implode(', ', $ins);
				pdoExec($q);
			}
		}

		//	Выбираю все значения указанных в файле параметров
		$db_params = [];
		$q = "SELECT `id`, `name_1` AS `value`, `param_id` FROM `extra_params_values` WHERE `param_id` IN(".implode(', ', $param_ids).")";
		$res = pdoFetchAll($q, PDO::FETCH_ASSOC);
		if ($res)
		{
			foreach ($res as $row)
			{
				$db_params[$row['value'].'-'.$row['param_id']] = $row['id'];
			}
		}

		//	Добавляю привязки параметров к товарам из файла
		$limit = 100;
		$offset = 0;
		if (isset($_SESSION['offset']))
		{
			$offset = $_SESSION['offset'];
		}
		while(TRUE)
		{
			$q = "SELECT p.`id`, i.`".implode('`, i.`', array_keys($fields))."` "
				."FROM `import_products` i "
				."LEFT JOIN `catalog_products` p ON p.`import_id`=i.`import_id` "
				."WHERE p.`id`>0 "
				."LIMIT ".$limit." OFFSET ".$offset;
			$res = pdoFetchAll($q, PDO::FETCH_ASSOC);
			if ($res)
			{
				$ins = [];
				foreach ($res as $row)
				{
					foreach ($fields as $field)
					{
						$value = explode(';', $row[$field['key']]);
						$value = array_map('trim', $value);
						foreach ($value as $v)
						{
							if (isset($db_params[$v.'-'.$field['table_id']]))
							{
								$ins[] = "(".$row['id'].", ".$field['table_id'].", ".$db_params[$v.'-'.$field['table_id']].")";
							}
						}
					}
				}

				if (count($ins))
				{
					$q = "INSERT IGNORE INTO `extra_params_products_assoc` (`product_id`, `param_id`, `value_id`) VALUES ".implode(', ', $ins);
					pdoExec($q);
				}

				$offset += $limit;
				$_SESSION['offset'] = $offset;
			}
			else
			{
				$_SESSION['move'] = 'files';
				unset($_SESSION['offset']);
				break;
			}

			if (microtime(TRUE) - $tm > 30)
			{
				break;
			}
		}

		//	Обновляю кеш параметров
		admin_catalog_products::cacheExtraParams();
		
		/*$q = "TRUNCATE TABLE `extra_params_cache`";
		pdoExec($q);
		$q = "INSERT IGNORE INTO `extra_params_cache` SELECT * FROM `extra_params_cache_view`";
		pdoExec($q);
		$q = "INSERT IGNORE INTO `catalog_products` (`id`, `params`) "
			."SELECT `product_id`, GROUP_CONCAT(`params` ORDER BY `param_id` SEPARATOR '') FROM ( "
			."SELECT `product_id`, `param_id`, CONCAT(':', GROUP_CONCAT(CONCAT('-', `value_id`, '-') ORDER BY `value_id` ASC SEPARATOR ''), ':') AS `params` "
			."FROM `extra_params_cache` "
			."GROUP BY `product_id`, `param_id` "
			."ORDER BY `param_id` ASC "
			.") t "
			."GROUP BY `product_id` "
			."ON DUPLICATE KEY UPDATE `params`=VALUES(`params`)";
		pdoExec($q);*/
	}

	private function move_product_files($selected_fields)
	{
		$tm = microtime(TRUE);

		if (!isset($_SESSION['offset']))
		{
			//	Перевожу имена всех файлов в нижний регистр
			if ($handle = opendir(ROOT.'/import_files/'))
			{
				while (false !== ($file = readdir($handle)))
				{
					if (!in_array($file, array('.', '..')))
					{
						rename(ROOT.'/import_files/'.$file, ROOT.'/import_files/'.mb_strtolower($file, 'UTF-8'));
					}
				}
				closedir($handle);
			}
		}


        $series = FALSE;
        if (in_array('p_seriya', $selected_fields) && in_array('p_proizvoditel', $selected_fields))
        {
            $series = TRUE;
        }

        $limit = 100;
		$offset = 0;
		if (isset($_SESSION['offset']))
		{
			$offset = $_SESSION['offset'];
		}
		while (TRUE)
		{
			//	Добавляю фотографии товара
			$q = "SELECT p.`id`, p.`articul` ";
            if ($series)
            {
                $q .= ", i.`p_seriya`, i.`p_proizvoditel` ";
            }
			$q .= "FROM `catalog_products` p LEFT JOIN `import_products` i ON i.`import_id`=p.`import_id` "
                ."WHERE i.`import_id`>0 "
				."LIMIT ".$limit." OFFSET ".$offset;
			$res = pdoFetchAll($q, PDO::FETCH_ASSOC);
			if ($res)
			{
				foreach ($res as $row)
				{
					//	Все файлы
					$source = array_merge(
						glob(ROOT.'/import_files/'.mb_strtolower($row['articul'], 'UTF-8').'.*'),
						glob(ROOT.'/import_files/'.mb_strtolower($row['articul'], 'UTF-8').'-[23456789].*')
					);

                    /*
                    if ($series)
                    {
                        $row['p_seriya'] = trim($row['p_seriya']);
                        $row['p_proizvoditel'] = trim($row['p_proizvoditel']);
                        $source = array_merge($source, glob(ROOT.'/import_files/'.mb_strtolower($row['p_proizvoditel'], 'UTF-8').'/'.mb_strtolower($row['p_seriya'], 'UTF-8').'/*.*'));
                        $row['p_proizvoditel'] = trim(preg_replace('#\(.*$#', '', $row['p_proizvoditel']));
                        $source = array_merge($source, glob(ROOT.'/import_files/'.mb_strtolower($row['p_proizvoditel'], 'UTF-8').'/'.mb_strtolower($row['p_seriya'], 'UTF-8').'/*.*'));
                    }
                    */

					if($source)
					{
                        //	Фотографии товара
						$images = array();
						//	Файлы товара для скачивания
						$files = array();
						//	Распределяю файлы по назначению
						foreach ($source as $s)
						{
							$ext = mb_strtolower(preg_replace('#^(.+)\.(\w+)$#', '$2', $s), 'UTF-8');
							if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif')))
							{
								$images[] = array(
									'path' => $s,
									'ext' => $ext
								);
							}
							else
							{
								$files[] = array(
									'path' => $s,
									'ext' => $ext
								);
							}
						}

						//	Фотографии товаров
						if (count($images))
						{
							//	Директория для фотографий
							$dir = ROOT.'/images/catalog_products/'.floor($row['id'] / 1000).'/';
							if (!is_dir($dir))
							{
								mkdir($dir, 0777, TRUE);
								chmod($dir, 0777);
							}

							foreach ($images as $pos => $image)
							{
								$fname = $dir.'catalog_products.'.$row['id'].'.'.($pos + 1).'.b.jpg';
								//	Фото добавляется только если его ещё нет
								if (!file_exists($fname))
								{
									$this->scale_image($image['path'], '1025x725', 'proportional', $fname);
									$this->scale_image($image['path'], '200x200', 'fixed-fill', str_replace('.b.', '.s.', $fname));
								}
							}
						}

						//	Файлы для скачивания
						if (count($files))
						{
							$q = "SELECT `id` "
								."FROM `files` "
								."WHERE `table_name`='catalog_products' AND `record_id`=".$row['id'];
							$exist = pdoFetchAll($q);
							foreach ($files as $pos => $file)
							{
								//	Файл добавляется только если его ещё нет
								if (!isset($exist[$pos]))
								{
									$name = preg_replace('#^(.+)/([^/]+)$#', '$2', $file['path']);
									$q = "INSERT INTO `files` SET "
										."`title_1`=".pdoEscape($name).", "
										."`title_2`=".pdoEscape($name).", "
										."`filename`='', "
										."`format`=".pdoEscape($file['ext']).", "
										."`table_name`='catalog_products', "
										."`record_id`=".$row['id'].", "
										."`creation_time`=".time();
									pdoQuery($q);
									$file_id = pdoLastInsertId();

									if ($file_id  > 0)
									{
										//	Директория для файлов
										$dir = ROOT.'/userfiles/'.$file['ext'].'/';
										if (!is_dir($dir))
										{
											mkdir($dir, 0777, TRUE);
											chmod($dir, 0777);
										}

										$fname = preg_replace('#\.'.$file['ext'].'$#', '_'.$file_id.'.'.$file['ext'], $name);

										copy($file['path'], $dir.$fname);
										$q = "UPDATE `files` SET "
											."`filename`=".pdoEscape($fname)." "
											."WHERE `id`=".$file_id;
										pdoQuery($q);
									}
								}
							}
						}
					}
				}

				$offset += $limit;
				$_SESSION['offset'] = $offset;
			}
			else
			{
				$_SESSION['move'] = 'done';
				break;
			}

			if (microtime(TRUE) - $tm > 30)
			{
				break;
			}
		}
	}

	//	Изменение размеров фотографии
	private function scale_image($fname, $new_size, $scale_method = 'proportional', $new_fname = NULL)
	{
		if (!file_exists($fname))
		{
			return FALSE;
		}
		//	Если новое имя не указано, тогда файл будет заменён изменённой версией
		if (!$new_fname)
		{
			$new_fname = $fname;
		}
		//	Размер в базе хранится в формате 100x100
		$new_size = explode('x', strtolower($new_size));
		if (count($new_size) != 2 || $new_size[0] <= 0 || $new_size[1] <= 0)
		{
			return FALSE;
		}
		$size = getimagesize($fname);
		//	Формирую массив координат для переноса изображения из старого в новое в зависимости от типа ресайза
		$coord = array(
			'src_x' => 0,
			'src_y' => 0,
			'dst_x' => 0,
			'dst_y' => 0,
			'src_w' => 0,
			'src_h' => 0,
			'dst_w' => 0,
			'dst_h' => 0,
			'img_w' => $new_size[0],
			'img_h' => $new_size[1]
		);
		switch ($scale_method)
		{
			//	Пропорциональное изменение размера - вписать фото в прямоугольник указанного размера
			case 'proportional':
				$coord['src_w'] = $size[0];
				$coord['src_h'] = $size[1];

				if ($size[0] > $new_size[0] || $size[1] > $new_size[1])
				{
					$prop = $size[0] / $size[1];
					if ($size[0] > $size[1])
					{
						$new_w = $new_size[0];
						$new_h = $new_w / $prop;
					}
					else
					{
						$new_h = $new_size[1];
						$new_w = $new_h * $prop;
					}
				}
				else
				{
					$new_w = $size[0];
					$new_h = $size[1];
				}

				$coord['dst_w'] = (int)$new_w;
				$coord['dst_h'] = (int)$new_h;
				$coord['img_w'] = $coord['dst_w'];
				$coord['img_h'] = $coord['dst_h'];
				break;
			//	Фиксированное фото указанного размера. Исходник уменьшается так, чтобы заполнить всю площать нового фото. Лишние части обрезаются
			case 'fixed-crop':
				//	Определяю пропорцию результирующего фото
				$prop = $new_size[0] / $new_size[1];
				//	При таком соотношении фиксирую высоту исходника, вставляю в новый размер и обрезаю левую и правую части
				if (($size[0] / $size[1]) > $prop)
				{
					$coord['src_w'] = $size[1] * $prop;
					$coord['src_h'] = $size[1];
					$coord['src_x'] = ceil(($size[0] - $coord['src_w']) / 2);
					$coord['src_y'] = 0;
				}
				//	Иначе - фиксирую ширину исходника, вставляю в новый размер и обрезаю верхнюю и нижнюю части
				else
				{
					$coord['src_w'] = $size[0];
					$coord['src_h'] = $size[0] / $prop;
					$coord['src_x'] = 0;
					$coord['src_y'] = ceil(($size[1] - $coord['src_h']) / 2);
				}
				//	Координаты в результирующем изображении устанавливаю по полному размеру
				$coord['dst_x'] = 0;
				$coord['dst_y'] = 0;
				$coord['dst_w'] = $new_size[0];
				$coord['dst_h'] = $new_size[1];
				break;
			//	Фиксированное фото указанного размера. Исходник уменьшается так, чтобы вписаться в размеры нового фото. Пустые области заливаются фоновым цветом
			case 'fixed-fill':
				//	Определяю пропорцию исходного фото
				$prop = $size[0] / $size[1];
				//	При таком соотношении фиксирую ширину исходника, вставляю в новый размер и заливаю цветом верхнюю и нижнюю части
				if ($prop > ($new_size[0] / $new_size[1]))
				{
					$coord['dst_w'] = $new_size[0];
					$coord['dst_h'] = $new_size[0] / $prop;
					$coord['dst_x'] = 0;
					$coord['dst_y'] = ceil(($new_size[1] - $coord['dst_h']) / 2);
				}
				//	Иначе - фиксирую высоту исходника, вставляю в новый размер и заливаю цветом левую и правую части
				else
				{
					$coord['dst_w'] = $new_size[1] * $prop;
					$coord['dst_h'] = $new_size[1];
					$coord['dst_x'] = ceil(($new_size[0] - $coord['dst_w']) / 2);
					$coord['dst_y'] = 0;
				}
				//	Координаты в исходном изображении устанавливаю по полному размеру
				$coord['src_x'] = 0;
				$coord['src_y'] = 0;
				$coord['src_w'] = $size[0];
				$coord['src_h'] = $size[1];
				break;
			default:
				return FALSE;
		}
		//	Открываю оригинал
		switch ($size[2])
		{
			case 1:
				$old_img = imagecreatefromgif($fname);
				break;
			case 2:
				$old_img = imagecreatefromjpeg($fname);
				break;
			case 3:
				$old_img = imagecreatefrompng($fname);
				break;
			default:
				return FALSE;
		}
		//	Создаю заготовку для переразмернного изображения
		$new_img = imagecreatetruecolor($coord['img_w'], $coord['img_h']);
		//	Заливаю заготовку цветом
		imagefill($new_img, 0, 0, 0xFFFFFF);
		//	Переношу изображение из оригинала в заготовку по рассчитанным координатам
		imagecopyresampled(
			$new_img,
			$old_img,
			$coord['dst_x'],
			$coord['dst_y'],
			$coord['src_x'],
			$coord['src_y'],
			$coord['dst_w'],
			$coord['dst_h'],
			$coord['src_w'],
			$coord['src_h']
		);
		//	Сохраняю заготовку на сервере
		switch (2)
		{
			case 1:
				imagegif($new_img, $new_fname);
				break;
			case 2:
				imagejpeg($new_img, $new_fname, 90);
				break;
			case 3:
				imagepng($new_img, $new_fname, 0);
				break;
			default:
				return FALSE;
		}
		//	Удаляю объекты изображений
		imagedestroy($old_img);
		imagedestroy($new_img);

		return TRUE;
	}
}
