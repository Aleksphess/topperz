<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders_items".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $name
 * @property double $count
 * @property string $url
 * @property double $price
 * @property double $price_full
 * @property double $installation
 * @property double $subtotal
 */
class OrdersItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'name', 'count', 'price', 'price_full'], 'required'],
            [['order_id', 'product_id'], 'integer'],
            [['name'], 'string'],
            [['count', 'price', 'price_full'], 'number'],
            [['url'], 'string', 'max' => 255],
            [['order_id', 'product_id'], 'unique', 'targetAttribute' => ['order_id', 'product_id'], 'message' => 'The combination of Order ID and Product ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'count' => Yii::t('app', 'Count'),
            'url' => Yii::t('app', 'Url'),
            'price' => Yii::t('app', 'Price'),
            'price_full' => Yii::t('app', 'Price Full'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\Queries\OrdersItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\Queries\OrdersItemsQuery(get_called_class());
    }

    public function saveOrderItems($items = null, $order_id = null)
    {
        if(!is_null($items) && !is_null($order_id))
        {
            foreach ($items as $item){
                $new_item             = new $this;
                $new_item->order_id   = $order_id;
                $new_item->product_id = $item['id'];
                $new_item->name       = $item['name'];
                $new_item->count      = $item['count'];
                $new_item->url        = $item['url'];
                $new_item->price      = $item['price'];
                $new_item->price_full = $item['cost'];
                if(!$new_item->save())
                {
                    return false;
                }
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
