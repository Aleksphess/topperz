<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Feedbacks;
use common\models\Callback;

class FormsController extends \common\components\BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions'   => ['callback','feedback',
                            'index',
                        ],
                        'allow'     => true,
                        'roles'     => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class'     => VerbFilter::className(),
                'actions'   => [
                    'feedback'         => ['post'],
                    'callback'         => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['callback','feedback'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionCallback()
    {
        $request = Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException("Wrong request", 400);
        }
        $post                   = $request->post();
        $model                  = new Callback();
        $model->name            = isset($post['name']) ? strip_tags($post['name']) : '';
        $model->phone           = isset($post['phone']) ? strip_tags($post['phone']) : '';
        $model->user_id         = Yii::$app->user->isGuest ? -1 : Yii::$app->user->identity->id;
        $model->creation_time   = date('U');
        if($model->save())
        {
            return true;
        } else {
            foreach ($model->errors as $error)
            {
                return $error[0];
            }
        }
    }
    public function actionFeedback()
    {
        // var_dump(1);die();
        $request = Yii::$app->request;
        if(!$request->isAjax)
        {
            throw new BadRequestHttpException("Wrong request", 400);
        }
        $post                   = $request->post();
        if(empty(Yii::$app->user->identity->orders)){
            return 'Вы еще ничего не заказывали';
        }
        $model                  = new Feedbacks();
        $model->name            = isset($post['name']) ? strip_tags($post['name']) : '';
        $model->email            = isset($post['email']) ? strip_tags($post['email']) : '';
        $model->mark            = isset($post['mark']) ? strip_tags($post['mark']) : '';
        $model->text            = isset($post['text']) ? strip_tags($post['text']) : '';
        $model->creation_time   = date('U');
        if($model->save())
        {
            return 'success';
        } else {
            foreach ($model->errors as $error)
            {
                return $error[0];
            }
        }
    }


}