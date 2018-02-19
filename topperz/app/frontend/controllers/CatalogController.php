<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\components\SeoComponent;
use common\models\CatalogCategories;
use common\models\CatalogProducts;

class CatalogController extends \common\components\BaseController
{
    
       public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only'  => ['index', 'category', 'category-by-type'],
                'rules' => [
                    [
                        'actions'   => ['index', 'category', 'product'],
                        'allow'     => true,
                        'roles'     => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'     => VerbFilter::className(),
                'actions'   => [
                    'index'                     => ['get'],
                    'category'                  => ['get'],
                    'product'                   => ['get'],
                    'filter'                    => ['get']
                ],
            ],
        ];
    }
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    
    public function actionCategory ($alias)
    {

        if ($alias != null and $alias != 'category') {
            $category = CatalogCategories::find()->joinWith('info')
                ->byAlias($alias, CatalogCategories::tableName())
                ->active()
                ->limit(1)
                ->one();
            if(is_null($category))
            {
                throw new NotFoundHttpException('Not Found!', 404);
            }
        }
        $query = ( $alias != 'category') ? CatalogProducts::find()->andWhere(['category_id'=>$category->id])->joinWith('info','params')
            :CatalogProducts::find()->joinWith('info','params');

        $query_count=$query->count();
        $pages = new Pagination(['totalCount' =>$query_count , 'pageSize' => 9]);
        $products=$query->offset($pages->offset)->limit($pages->limit)->orderBy('sort asc')->all();
        $categories = CatalogCategories::find()->active()->joinWith('info')->all();
        SeoComponent::setByTemplate('category', [
            'name' => (empty($category->info->title)) ? 'Все меню' : $category->info->title ,
        ]);
        if (empty($products))
        {
            return $this->render('empty.twig');
        }
            return $this->render('category.twig', [
                'category'  => $category,
                'products'      => $products,
                'pages'     => $pages,
                'categories'    => $categories

            ]);

    }
    public function actionProduct ($alias,$name_alt)
    {
        $category = CatalogCategories::find()
                ->byAlias($alias)
                ->active()
                ->limit(1)
                ->one();




        $product = CatalogProducts::find()
            ->where(['category_id'=>$category->id])
            ->byAlias($name_alt)
            ->joinWith('info','params')
            ->joinWith('consist')
            ->limit(1)
            ->one();
        $current_products = CatalogProducts::find()
            ->where(['id'=>explode(',',$product->also_ids)])
            ->all();
        $categories = CatalogCategories::find()->active()->joinWith('info')->all();
        SeoComponent::setByTemplate('product', [
            'name' => $product->info->title,
        ]);
        if (empty($product))
        {
            throw new NotFoundHttpException();
        }
        return $this->render('product.twig', [
            'category'  => $category,
            'product'      => $product,
            'current_products'  => $current_products,
            'categories'    => $categories

        ]);

    }
}