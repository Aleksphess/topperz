<?php

namespace frontend\controllers;

use Symfony\Component\Console\Question\Question;
use Twig\Node\Expression\Binary\AddBinary;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SeoComponent;
use common\models\Lots;
use common\models\User;
use yii\imagine\Image;
use common\models\Payment;
use common\models\AddressDelivery;


class UserController extends \common\components\BaseController
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class'     => AccessControl::className(),
//                'only'      => ['index'],
                'rules'     => [
                    [
                        'actions'   => ['index', 'settings', 'change-settings','payment-static','lot',
                            'change-password','add-address','delete-address','change-address','orders','question',
                            'save-question'
                        ],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save-question'         => ['post'],
                    'index'                 => ['get'],
                    'settings'              => ['get'],
                    'change-settings'       => ['post'],
                    'change-password'       => ['post'],
                    'add-address'           => ['post'],
                    'delete-address'        => ['post'],
                    'change-address'        => ['post'],
                    'orders'                => ['get'],
                    'question'                => ['get'],

                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'NOINDEX,NOFOLLOW'
        ]);
        SeoComponent::setByTemplate('user', [
            'name' => Yii::$app->params->view['profile'],
        ]);
                return $this->render('old_index.twig', [
										   ]);
    }
    

    
    public function actionChangeSettings()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request=Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException();
        }
        $post = $request->post();

            $current_user = User::findIdentity(Yii::$app->user->identity->id);
            $current_user->username=trim(strip_tags($post['username']));
            $current_user->email=trim(strip_tags($post['email']));
            $current_user->phone=trim(strip_tags($post['phone']));
            $current_user->facebook=trim(strip_tags($post['facebook']));
            $current_user->vk=trim(strip_tags($post['vk']));

            if( $current_user->update())
            {
                         return 'success';
            }
            return ['status' => false];


    }
    public function actionChangePassword()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request=Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException();
        }
        $post = $request->post();

        $current_user = User::findIdentity(Yii::$app->user->identity->id);
        $current_user->setPassword($post['password']);

        if( $current_user->update())
        {
            return 'success';
        }
        return ['status' => false];


    }
    public function actionAddAddress()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request=Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException();
        }
        $post = $request->post();
        $address = new AddressDelivery();
        $address->user_id = Yii::$app->user->identity->id;
        $address->address = $post['address'];
        $this->layout='main_added.twig';
        if( $address->save())
        {


            return $this->renderAjax('added.twig',['address' => $address]);
        }
        return ['status' => false];


    }
    public function actionChangeAddress()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request=Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException();
        }
        $post = $request->post();
        $address =  AddressDelivery::find()->where(['id'=>$post['id']])->limit(1)->one();

        $address->address = $post['address'];

        if( $address->update())
        {
            return 'success';
        }
        return ['status' => false];


    }
    public function actionDeleteAddress()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request=Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException();
        }
        $post = $request->post();
        $address = AddressDelivery::find()->where(['id'=>$post['id']])->limit(1)->one();

        if( $address->delete())
        {

            return 'success';
        }
        return ['status' => false];


    }

    public function actionOrders()
    {
        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'NOINDEX,NOFOLLOW'
        ]);
        SeoComponent::setByTemplate('user', [
            'name' => Yii::$app->params->view['user_orders'],
        ]);
        $orders = Yii::$app->user->identity->orders;

        return $this->render('orders.twig',[
            'orders'   =>  $orders,
        ]);
    }
    public function actionQuestion()
    {
        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => 'NOINDEX,NOFOLLOW'
        ]);
        SeoComponent::setByTemplate('user', [
            'name' => Yii::$app->params->view['user_question'],
        ]);

        return $this->render('question.twig',[

        ]);
    }
    public function actionSaveQuestion()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request=Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException();
        }
        $post = $request->post();
        $model = new \common\models\Question();
        $model->name            = isset($post['name']) ? strip_tags($post['name']) : '';
        $model->phone            = isset($post['phone']) ? strip_tags($post['phone']) : '';
        $model->question        =isset($post['comment']) ? strip_tags($post['comment']) : '';
        $model->user_id         = Yii::$app->user->identity->id;
        $model->creation_time   = date('U');
        if($model->save())
        {
            return true;
        }
        return ['status' => false];
    }
}