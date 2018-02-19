<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\components\SeoComponent;
use common\models\Pages;
use common\models\Lots;
use yii\helpers\Url;
use common\models\MainSlider;
use common\models\CatalogProducts;
use common\models\CatalogCategories;


class ContentController extends \common\components\BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'static', 'contacts','login','reset','logup'],
                'rules' => [
                    [
                        'actions' => ['signup','logup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['static', 'contacts','reset','login'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'index' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {

        $products=CatalogProducts::find()->joinWith('info','params')->orderBy('sort ASC')->limit(9)->all();
        $categories=CatalogCategories::find()->active()->joinWith('info')->orderBy('sort DESC')->all();
        $slides=MainSlider::find()->joinWith('info')->orderBy('sort DESC')->all();
        SeoComponent::setByTemplate('default', [
            'name' => Yii::$app->view->params['main'],
        ]);

        return $this->render('index.twig', [
            'products'  =>  $products,
            'categories'    => $categories,
            'slides'        =>  $slides
        ]);
    }




    public function actionStatic($alias)
    {
        $page=Pages::find()->byAlias($alias)->joinWith('info')->limit(1)->one();
        SeoComponent::setByTemplate('static_page', [
            'name' => $page->info->title,
        ]);
        return $this->render('static.twig', [
            'page' => $page,
        ]);
    }



    public function actionLogin()
    {
        SeoComponent::setByTemplate('static_page', [
            'name' => Yii::$app->view->params['login'],
        ]);
        if (!Yii::$app->user->isGuest)
        {
            return $this->redirect( Url::toRoute('/user/index'),301);
        }
        return $this->render('signin.twig');
    }

    public function actionLogup()
    {
        SeoComponent::setByTemplate('static_page', [
            'name' => Yii::$app->view->params['registration'],
        ]);
        return $this->render('logup.twig');
    }

}