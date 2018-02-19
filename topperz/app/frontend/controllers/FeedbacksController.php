<?php

namespace frontend\controllers;

use common\components\SeoComponent;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\Feedbacks;
use yii\data\Pagination;

class FeedbacksController extends \common\components\BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [

                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        SeoComponent::setByTemplate('default', [
            'name' => Yii::$app->params->view['feeedbacks'],
        ]);
        $query = Feedbacks::find()->active();
        $query_count=$query->count();
        $pages = new Pagination(['totalCount' =>$query_count , 'pageSize' => 6]);
        $feedbacks=$query->offset($pages->offset)->limit($pages->limit)->orderBy('sort asc')->all();


        return $this->render('index.twig',[
            'feedbacks' =>  $feedbacks,
            'pages' =>  $pages
        ]);
    }



}