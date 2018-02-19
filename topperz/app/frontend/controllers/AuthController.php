<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use common\models\User;
use common\models\SignupForm;
use common\models\LoginForm;
use common\components\SeoComponent;
/*use common\models\User;*/

class AuthController extends \common\components\BaseController
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout', 'login', 'sign-up', 'sign-in'],
                'rules' => [
                    [
                        'actions' => ['login', 'sign-up', 'sign-in','registration','sign-double','reset','reset-password'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login'     => ['get'],
                    'logout'    => ['get'],
                    'sign-in'   => ['post'],
                    'sign-up'   => ['post'],
                    'registration'   => ['post','get'],
                ],
            ],
        ];
    }
    
    /**
     * Shows user signin/signup page
     *
     * @return mixed
     */
    public function actionLogin()
    {
		//var_dump(1);die();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        
        return $this->render('signin.twig', []);
    }
    
    public function actionSignIn()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        //var_dump(1);die();
        $request = Yii::$app->request;
        $model = new LoginForm;


        $post=
        [
            'email'=>$request->post()['email'],
            'password'=>$request->post()['password'],
            'active'=>\common\models\User::findOne(['email'=>$request->post()['email']])->active,
        ];
       // var_dump($post);die();
        $model->setAttributes($post);
        if ($model->login()) {

           return ['answer'=>'success','url'=>Yii::$app->request->referrer];
        } else {
            foreach ($model->errors as $error)
            {
                return $error[0];
            }


        }
    }


    public function actionSignUp()
    {


        $request = Yii::$app->request;

        $model = new SignupForm();

		$model->setAttributes($request->post(),false);
		$post = $request->post();
        if($post['password']!=$post['password_repick'])
        {
            return 'Пароли не совпадают';
        }

        if ($model->validate()) {

            $user = $model->signup();

            if (!is_null($user)) {
                    $headers  = "Content-type: text/html; charset=UTF-8 \r\n";
                    $headers .= "From:3pies.ua \r\n";
                    mail($request->post()['email'],'Регистрация на 3pies.ua','Перейдите по ссылке для активации профиля '.$_SERVER['SERVER_NAME'].'/auth/'.$user->getAuthKey(), $headers);
                    mail('aleksphespro@gmail.com','Регистрация на 3pies.ua','У вас появился новый пользователь'.$request->post()['username'], $headers);
                    return 'success';
            }

        }
        else
        {
         //   print_r ($model->errors);die();
            foreach ($model->errors as $error)
            {
                return $error[0];
            }

        }
    }
    public function actionRegistration($key)
    {
        //  var_dump(111);die();
       // var_dump($auth_key);die();

            $current_user=\common\models\User::findOne(['auth_key'=>$key]);
            $current_user->active =1;
            //var_dump($current_user);die();
            if( $current_user->save()) {

                return $this->redirect(Url::to('/login'));
        }




    }

    public function actionReset()
    {
        //var_dump(1);die();
        $request = Yii::$app->request;
        $current_user=\common\models\User::findOne(['email'=>$request->post()['email']]);
        $current_user->generatePasswordResetToken();
        if($current_user->save())
        {
            $headers  = "Content-type: text/html; charset=UTF-8 \r\n";
            $headers .= "From:franch.ua \r\n";
            if(mail($request->post()['email'],'Восстановление пароля на franch.ua','Перейдите по ссылке для восстановления пароля test8.digitalforce.ua/reset/'.$current_user->password_reset_token, $headers))
            {
                return 'success';
            }
        }
    }
    public function actionResetPassword()
    {
        //var_dump(1);die();
        $request = Yii::$app->request;
        $current_user=\common\models\User::findOne(['id'=>$request->post()['id']]);
        $current_user->setPassword($request->post()['password']);
        $current_user->removePasswordResetToken();
        if($current_user->save())
        {

                return 'success';

        }
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Url::home());
    }
}