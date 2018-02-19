<?php
namespace frontend\controllers;

use Yii;
use common\components\BaseController;
use common\models\CatalogParams;
use common\models\Orders;
use common\models\OrdersItems;
use common\components\SeoComponent;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;




class CartController extends BaseController
{

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function behaviors() {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'order' => ['get'],
                    'new-order' => ['post'],
                    'request'   => ['post'],
                    'change-count'  => ['post'],
                    'delete-from-backet'    => ['post'],
                    'clear'                 => ['post'],
                ]
            ]
        ];
    }

    public function actionRequest()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $answer = [
            'result' => 'ok',
            'count' => 0,
            'cost' => 0,
            'products' => [],
            'man' => "$('.cart-count').html(answer.count);"
                ."$('.cart-cost').html(answer.cost);"
                ."if(answer.count>0)$('.cart-box').removeClass('empty');else $('.cart-box').addClass('empty');"
                ."for(var p in answer.products){ $('.cart-cost-'+p).html(answer.products[p].cost); $('.cart-count-'+p).val(answer.products[p].count); }"
        ];

        if (isset($post))
        {
            switch ($post['method'])
            {
                case 'add':
                    if (isset($post['params']))
                    {
                        if (!is_array($post['params']))
                        {
                            $post['params'] = [$post['params']];
                        }

                        $post['params'] = array_map('intval', $post['params']);

                        if (!isset($post['count']) || $post['count'] < 1)
                        {
                            $post['count'] = 1;
                        }

                        foreach ($post['params'] as $id)
                        {
                            //  Ищу товар по ID
                            $product = CatalogParams::find()->byId($id)->one();
                            //  Если товар есть в наличии, выполняю добавление в корзину
                            if ($product->id == $id && $id > 0)
                            {
                                if (!isset($_SESSION['cart'][$id]))
                                {
                                    $_SESSION['cart'][$id] = 0;
                                }
                                $_SESSION['cart'][$id] += (int)$_POST['count'];
                                $cart_count = count($_SESSION['cart']);
                                $summ=0;
                                foreach ($_SESSION['cart'] as $item_id => $item_count) {
                                    $summ+=(CatalogParams::find()->where(['id'=>$item_id])->limit(1)->one()->price*$item_count);
                                }

                                return ['cart_count' => $cart_count,'cost' => $summ];

                            }
                        }

//                        $answer['popup'] = '@app/views/cart/added.twig';
                    }
                    break;

                case 'change':
                    if (isset($_POST['product_id']) && $_POST['product_id'] > 0 && isset($_SESSION['cart'][$_POST['product_id']]) && isset($_POST['count']) && $_POST['count'] > 0)
                    {
                        //  Ищу товар по ID
                        $product = CatalogProducts::find()->byId($_POST['product_id'])->one();
                        if ($product->id > 0 && $product->available > 0)
                        {
                            $_SESSION['cart'][$product->id] = (int)$_POST['count'];
                            if ($_SESSION['cart'][$product->id] > $product->available)
                            {
                                $_SESSION['cart'][$product->id] = $product->available;
                            }
                        }
                    }
                    break;

                case 'remove':
                    if (isset($_POST['product_id']) && $_POST['product_id'] > 0 && isset($_SESSION['cart'][$_POST['product_id']]))
                    {
                        unset($_SESSION['cart'][$_POST['product_id']]);
                        return true;
//                            $answer['location'] = 'reload';
                    }
                    break;

                case 'clear':
                    $_SESSION['cart'] = [];
//                        $answer['location'] = 'reload';
                    break;
            }
        }
      //  var_dump(1);die();
        $answer = array_merge($answer, Orders::getCartInfo());

        echo json_encode($answer, JSON_NUMERIC_CHECK);
    }
    public function actionChangeCount()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        if (isset($post))
        {
            if (isset($post['id']) && $_POST['id'] > 0 && isset($_SESSION['cart'][$post['id']]) && isset($post['count']) && $post['count'] > 0)
            {
                $_SESSION['cart'][$post['id']]=$post['count'];
                $param_summ = (CatalogParams::find()->where(['id'=>$post['id']])->limit(1)->one()->price)*$post['count'];
                $summ=0;
                foreach ($_SESSION['cart'] as $item_id => $item_count) {
                    $summ+=(CatalogParams::find()->where(['id'=>$item_id])->limit(1)->one()->price*$item_count);
                }

                return ['param_summ' => $param_summ,'cost' => $summ];
            }

        }
    }
    public function actionDeleteFromBacket()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        if (isset($post['id']) && $_POST['id'] > 0 && isset($_SESSION['cart'][$post['id']]) )
        {
            unset($_SESSION['cart'][$_POST['id']]);
            $cart_count = count($_SESSION['cart']);
            $summ=0;
            foreach ($_SESSION['cart'] as $item_id => $item_count) {
                $summ+=(CatalogParams::find()->where(['id'=>$item_id])->limit(1)->one()->price*$item_count);
            }

            return ['cart_count' => $cart_count,'cost' => $summ];
        }
    }



    public function actionBacket()
    {
        $session = Yii::$app->session;

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'NOINDEX,NOFOLLOW'
        ]);

        SeoComponent::setByTemplate('backet', [
            'name' => Yii::$app->params->view['backet'],
        ]);

        if($session->isActive && $session->has('cart') && !empty($session['cart']))
        {
            $cart     = $session['cart'];
            $products = [];
            $sum = 0;
            $also_ids = '';
            $params_all=[];
            foreach ($cart as $item_id => $item_count)
            {
                // пришлось пойти на такое извращение
                // т.к. при использовании asArray() геттер не сработал
                // asArray() привращает объект масив и геттеры не работают

                $params                = CatalogParams::find()->byId($item_id)->asArray()->one();
                $params_obj            = CatalogParams::find()->byId($item_id)->one();
                $params['count_order'] = $item_count;
                $params['simg']        = $params_obj->parent->simg;
                $params['url']         = $params_obj->parent->url;
                $params['title']       = $params_obj->parent->info->title;
                $params['full_price']   = $params['price']*$item_count;
                $params_all[]             = $params;
                $sum += (int)$params['price'] * $item_count;

            }




            return $this->render('backet.twig', [
                'params'      => $params_all,

                'sum'           => $sum,

            ]);

        } else
        {
            return $this->render('empty_cart.twig', [

            ]);
        }

    }

    public function actionOrder()
    {
        $session = Yii::$app->session;

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'NOINDEX,NOFOLLOW'
        ]);

        SeoComponent::setByTemplate('backet', [
            'name' => Yii::$app->params->view['order'],
        ]);

        if($session->isActive && $session->has('cart') && !empty($session['cart'])) {
            $cart = $session['cart'];
            $products = [];
            $sum = 0;
            $also_ids = '';
            $params_all = [];
            foreach ($cart as $item_id => $item_count) {
                // пришлось пойти на такое извращение
                // т.к. при использовании asArray() геттер не сработал
                //asArray() привращает объект масив и геттеры не работают

                $params = CatalogParams::find()->byId($item_id)->asArray()->one();
                $params_obj = CatalogParams::find()->byId($item_id)->one();
                $params['count_order'] = $item_count;
                $params['simg'] = $params_obj->parent->simg;
                $params['url'] = $params_obj->parent->url;
                $params['title'] = $params_obj->parent->info->title;
                $params['full_price'] = $params['price'] * $item_count;
                $params_all[] = $params;
                $sum += (int)$params['price'] * $item_count;

            }


            return $this->render('order.twig', [
                'params' => $params_all,
                'sum' => $sum,

            ]);
        } else
        {
            return $this->render('empty_cart.twig', [
            ]);
        }
    }
    public function actionNewOrder()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;
        if ($request->isAjax)
        {
            $session     = Yii::$app->session;
            $post        = $request->post();

            $order       = new Orders();
            $order_items = new OrdersItems();

            $backet = Orders::getCartInfo();



            $transaction          = Yii::$app->getDb()->beginTransaction();
            $order->user_id       = (Yii::$app->user->isGuest) ? -1 : Yii::$app->user->identity->id;
            $order->name          = trim(strip_tags($post['username']));
            $order->email         = trim(strip_tags($post['email']));
            $order->phone         = trim(strip_tags($post['phone']));
            $order->comment       = trim(strip_tags($post['comment']));
            $order->address       = trim(strip_tags($post['address']));
            $order->delivery_id   = trim(strip_tags($post['delivery_type']));
            $order->total         = trim(strip_tags($post['price']));
            $order->pay_id        = trim(strip_tags($post['pay_type']));
            $order->status_id     = 3; // статус "новый заказ"
            $order->creation_time = date('U');
            $order->update_time   = 0;


            if($order->save())
            {
                $save_items_status = $order_items->saveOrderItems($backet['params'], $order->id);

                if($save_items_status)
                {
             //       $data['products'] = $backet['products'];
            //        $data['order'] = $order;
           //         $mail = MailComponent::mailsend($data, 'order_letter', [$order->email, 'sales@vagonka.kz', 'azhibayev.r@vagonka.kz'], "Заказ №".$order->id." - Buratino");
                    $transaction->commit();

                    $session['cart'] = [];

                        $headers  = "Content-type: text/html; charset=UTF-8 \r\n";
                        $headers .= "From:3pies.ua \r\n";
                        mail('aleksphesspro@gmail.com','Новый заказ на 3pies.ua','У вас появился новый заказ на сайте', $headers);


                    $answer['status'] = true;
                    $answer['url'] = \yii\helpers\Url::to('/success');
                    $answer['msg'] = 'All ok';

                }
                else
                {
                    $transaction->rollBack();
                    $answer['status'] = false;
                    $answer['url'] = '';
                    $answer['msg'] = 'Something is wrong';
                }
            }
            else
            {
                $transaction->rollBack();
                $answer['status'] = false;
                $answer['url'] = '';
                $answer['msg'] = $order->getErrors();
            }
            return $answer;
        }
        else
        {
            throw new BadRequestHttpException('Wrong request!');
        }
    }

    public function actionClear()
    {
        $_SESSION['cart'] = [];
        return Url::toRoute('/category');
    }
    public function actionSuccess()
    {
        return $this->render('success.twig', [

        ]);
    }

}