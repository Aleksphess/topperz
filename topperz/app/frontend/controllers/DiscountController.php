<?php

namespace frontend\controllers;

use common\components\SeoComponent;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\Discounts;

class DiscountController extends \common\components\BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view'],
                'rules' => [

                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'view' => ['get'],
                    'index' => ['get'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        SeoComponent::setByTemplate('default', [
            'name' => 'Акции',
        ]);
        $discounts = Discounts::find()->active()->joinWith('info')->all();

        return $this->render('index.twig',[
            'discounts'=>$discounts
        ]);
    }

    public function actionView($alias)
    {
        $discount=Discounts::find()->byAlias($alias)->active()->joinWith('info')->limit(1)->one();
        SeoComponent::setByTemplate('default', [
            'name' => $discount->info->title
        ]);

        return $this->render('view.twig', [
            'discount'=>$discount
        ]);
    }

}
