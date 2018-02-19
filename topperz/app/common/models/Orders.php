<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Orders extends ActiveRecord
{
    private static $params = NULL;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'delivery_id', 'pay_id'], 'required'],
            [['name', 'phone'], 'string', 'min' => 2, 'max' => 100],
            [['comment'], 'string', 'min' => 0, 'max' => 1000],
            [['email'], 'email'],
            [['status_id', 'pay_id', 'delivery_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Имя'),
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'comment' => Yii::t('app', 'Комментарий'),
            'address' => Yii::t('app', 'Адрес доставки'),
            'delivery_id' => Yii::t('app', 'Способ доставки'),
            'pay_id' => Yii::t('app', 'Способ оплаты'),
            'city_id' => Yii::t('app', 'Город доставки'),
            'filial_id' => Yii::t('app', 'Отделение Новой Почты'),
        ];
    }

    public static function getCartInfo()
    {
        $cart = [
                'params' => [],
                'count' => 0,
                'cost' => 0,
                'url' => Url::toRoute('/cart/index')
        ];
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']))
        {
            $cart['params'] = $_SESSION['cart'];
        }

        if (count($cart['params']))
        {
          //  $params = [];
            foreach ($cart['params'] as $item_id => $item_count)
            {
                $param= CatalogParams::find()->byId($item_id)->limit(1)->one();

                $cart['count'] += $cart['params'][$param->id];
                $cart['cost'] += $cart['params'][$param->id] * $param->price;
                $cart['params'][$param->id] = [
                    'id' => $param->id,
                    'name' => $param->parent->info->title,
                    'url' => $param->parent->url,
                    'price' => $param->price,
                    'count' => $cart['params'][$param->id],
                    'cost' => $cart['params'][$param->id] * $param->price,
                    'image' => $param->parent->simg
                ];
            }
        }

        return $cart;
    }

    public static function getOrdersParams()
    {
        if (self::$params === NULL)
        {
            self::$params = [];

            $conn = Yii::$app->getDb();
            $q = "SELECT `id`, `name`, `type`, `add_cost`, `system_key` "
                    ."FROM `orders_params` "
                    ."ORDER BY `sort` ASC";
            $res = $conn->createCommand($q)->queryAll();
            if ($res)
            {
                foreach ($res as $row)
                {
                    self::$params[$row['type']][$row['id']] = $row;
                }
            }
        }

        return self::$params;
    }

    public function getProducts()
    {
        $products = [];
        $conn = Yii::$app->getDb();
        $q = "SELECT `product_id`, `count`, `price`, `installation`, `subtotal` "
                ."FROM `orders_items` "
                ."WHERE `order_id`=".(int)$this->id;
        $res = $conn->createCommand($q)->queryAll();
        if (is_array($res) && count($res))
        {
            foreach ($res as $row)
            {
                $products[$row['product_id']] = $row;
            }
        }

        $info = CatalogProducts::find()->base()->byId(array_keys($products))->all();
        if ($info)
        {
            foreach ($info as $one)
            {
                $products[$one->id]['name'] = $one->info->name;
                $products[$one->id]['image'] = $one->imgs[0];
                $products[$one->id]['articul'] = $one->articul;
                $products[$one->id]['url'] = $one->url;
            }
        }

        return $products;
    }
    public function getItems()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id']);
    }
}