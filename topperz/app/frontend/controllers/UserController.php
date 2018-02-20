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
        $this->view->registerJsFile('js/date.js',
            ['depends' => [\frontend\assets\AppAsset::className()]]);

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
            $current_user->surname=trim(strip_tags($post['surname']));
            $current_user->middle_name=trim(strip_tags($post['middle_name']));
            $current_user->dop_phone=trim(strip_tags($post['phone_alt']));
            $current_user->date=trim(strip_tags($post['birthday']));


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

        if(!Yii::$app->getSecurity()->validatePassword($post['old_password'], $current_user->password_hash))
        {
            return ['status'=> false,'text' => 'Вы ввели неправильный старый пароль'];
        }
        if($post['new_password']==$post['old_password'])
        {
            return ['status'=> false,'text' => 'Старый и новый пароли  совпадают'];
        }
        if($post['new_password']!=$post['repeat_password'])
        {
            return ['status'=> false,'text' => 'Пароли не совпадают'];
        }

        $current_user->setPassword($post['new_password']);

        if( $current_user->update())
        {
            return ['status'=> true,'text' => 'Успешно'];
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
        $address->street = trim(strip_tags($post['street']));
        $address->house = trim(strip_tags($post['house']));
        $address->building = trim(strip_tags($post['building']));
        $address->apartment = trim(strip_tags($post['apartment']));
        $address->entrance = trim(strip_tags($post['entrance']));
        $address->doorphone_code = trim(strip_tags($post['doorphone_code']));
        $address->floar = trim(strip_tags($post['floar']));
        $street = ($address->street) ? $address->street.', ' : '';
        $house = ($address->house) ? 'Дом '.$address->house.', ' : '';
        $building = ($address->building) ? 'Корпус '.$address->building.', ' : '';
        $apartment = ($address->apartment) ? 'Кв. '.$address->apartment.', ' : '';
        $entrance = ($address->entrance) ? 'Подъезд '.$address->entrance.', ' : '';
        $doorphone_code = ($address->doorphone_code) ? 'Код'.$address->doorphone_code.', ' : '';
        $floar = ($address->floar) ? 'Этаж '.$address->floar.', ' : '';
        $address->full_address = $street.$house.$building.$apartment.$entrance.$doorphone_code.$floar;


        $this->layout='main_added.twig';
        if( $address->save())
        {


            return ['status'=>true,'address'=>$address->full_address];

        }
        return ['status' => false];


    }





}