<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\SeoComponent;
//use common\models\Lots;
use common\models\User;
use common\models\UserBookmarks;

class UserBookmarksController extends \common\components\BaseController
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class'     => AccessControl::className(),
//                'only'      => ['index'],
                'rules'     => [
                    [
                        'actions'   => ['index', 'bookmark','payment'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get'],
                    'bookmark'  => ['post'],
                   
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
        if (in_array($action->id, ['bookmark'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    } 
    
    public function actionIndex()
    {
        SeoComponent::setByTemplate('default', [
            'name' => Yii::$app->user->identity->username,
        ]);
        $bookmarks = UserBookmarks::find()->where([UserBookmarks::tableName().'.user_id' => Yii::$app->user->identity->id])
                ->innerJoinWith(['lot'] , true)->andWhere(['lots.active'=>1])
                ->all();
        //var_dump($bookmarks);die();
        return $this->render('index.twig', [
            'bookmarks'  => $bookmarks
        ]);
    }
    
    /**
     * Manipulations with bookmarks (create/remove)
     * @param type $lot_id
     * @return type
     * @throws \yii\base\Exception
     */
    public function actionBookmark($lot_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_numeric($lot_id))
        {
            throw new \yii\base\Exception('Wrong data!', 400);
        }
        $bookmark = UserBookmarks::find()
                        ->where([UserBookmarks::tableName().'.user_id' => Yii::$app->user->identity->id])
                        ->andWhere([UserBookmarks::tableName().'.lot_id' => (int)$lot_id])
                        ->limit(1)->one();
        if(is_null($bookmark))
        {
            try {
                $bookmark           = new UserBookmarks();
                $bookmark->lot_id   = (int)$lot_id;
                $bookmark->user_id  = Yii::$app->user->identity->id;
                $bookmark->save();

            } catch (Exception $ex) {
                return ['status' => false];
            }
        } else {
            $bookmark->delete();
        }
        return ['status' => true];
    }
}