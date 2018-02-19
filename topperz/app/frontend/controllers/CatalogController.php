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
                        'actions'   => ['index', 'category', 'product','sort','type'],
                        'allow'     => true,
                        'roles'     => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'     => VerbFilter::className(),
                'actions'   => [
                    'type'                      => ['get'],
                    'index'                     => ['get'],
                    'category'                  => ['get'],
                    'sort'                      => ['get'],
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

                ->limit(1)
                ->one();

            if(is_null($category))
            {
                throw new NotFoundHttpException('Not Found!', 404);
            }
        }
        $products = CatalogProducts::find()->andWhere(['category_id'=>$category->id])->joinWith('info','params')
            ->joinWith('consists','topics')->orderBy('sort DESC')->all();
        SeoComponent::setByTemplate('category', [
            'name' =>$category->info->title ,
        ]);
        if (empty($products))
        {
            return $this->render('empty.twig');
        }
            return $this->render('category.twig', [
                'category'  => $category,
                'products'      => $products,



            ]);

    }

    //->orderBy([new \yii\db\Expression("FIELD(label_id,  1,3,2,-1)")]) сортировка по выражению


    public function actionSort($alias, $sort)
    {
        if ($alias != null and $alias != 'category') {
            $category = CatalogCategories::find()->joinWith('info')
                ->byAlias($alias, CatalogCategories::tableName())

                ->limit(1)
                ->one();

            if(is_null($category))
            {
                throw new NotFoundHttpException('Not Found!', 404);
            }
        }
        $query = CatalogProducts::find()->andWhere(['category_id'=>$category->id])->joinWith('info','params')
            ->joinWith('consists','topics');
        if ($sort == 'asc')
        {
            $products=$query->orderBy('price asc')->all();
        }
        elseif ($sort == 'desc') {
            $products=$query->orderBy('price desc')->all();
        }
        elseif ($sort== 'new') {
            $products=$query->orderBy([new \yii\db\Expression("FIELD(label_id,  1,3,2,-1)")])->all();
        }elseif ($sort == 'stock') {
            $products=$query->orderBy([new \yii\db\Expression("FIELD(label_id,  3,1,2,-1)")])->all();
        }elseif ($sort == 'hit') {
            $products=$query->orderBy([new \yii\db\Expression("FIELD(label_id,  2,3,1,-1)")])->all();
        } else {
            throw new NotFoundHttpException();
        }


        SeoComponent::setByTemplate('category', [
            'name' =>$category->info->title ,
        ]);
        if (empty($products))
        {
            return $this->render('empty.twig');
        }
        return $this->render('category.twig', [
            'category'  => $category,
            'products'      => $products,
            



        ]);

    }

    public function actionType ($alias,$type)
    {

        if ($alias != null and $alias != 'category') {
            $category = CatalogCategories::find()->joinWith('info')
                ->byAlias($alias, CatalogCategories::tableName())

                ->limit(1)
                ->one();

            if(is_null($category))
            {
                throw new NotFoundHttpException('Not Found!', 404);
            }
        }
        $products = CatalogProducts::find()->andWhere(['category_id'=>$category->id])->andWhere(['type'=>$type])
            ->joinWith('info','params')
            ->joinWith('consists','topics')->orderBy('sort DESC')->all();
        SeoComponent::setByTemplate('category', [
            'name' =>$category->info->title ,
        ]);
        if (empty($products))
        {
            return $this->render('empty.twig');
        }
        return $this->render('category.twig', [
            'category'  => $category,
            'products'      => $products,



        ]);

    }



    public function actionProduct ($alias,$name_alt)
    {
        $category = CatalogCategories::find()
                ->byAlias($alias)

                ->limit(1)
                ->one();




        $product = CatalogProducts::find()
            ->where(['category_id'=>$category->id])
            ->byAlias($name_alt)
            ->joinWith('info','params')
            ->joinWith('consists','topics')
            ->limit(1)
            ->one();
        $current_products = CatalogProducts::find()
            ->where(['id'=>explode(',',$product->also_ids)])
            ->all();
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
            

        ]);

    }
}